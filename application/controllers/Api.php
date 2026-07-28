<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * JSON API for the "Receive Orders" desktop app.
 * Token-authenticated (X-Api-Token or Authorization: Bearer header), scoped
 * to a single restaurant owner. Business logic is reused from Order_model
 * where possible; restaurant-scoped/non-redirecting variants of the owner
 * order flow live in Order_model under "RECEIVE ORDERS DESKTOP APP API HELPERS".
 */
include 'Base.php';

class Api extends Base
{
    private $api_restaurant = null;

    public function __construct()
    {
        parent::__construct();
    }

    // ---------------------------------------------------------------
    // RESPONSE HELPERS
    // ---------------------------------------------------------------
    private function respond($data, $code = 200)
    {
        $this->output
            ->set_status_header($code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data));
    }

    private function fail($message, $code = 400)
    {
        $this->respond(['success' => false, 'message' => $message], $code);
    }

    // ---------------------------------------------------------------
    // TOKEN AUTH
    // ---------------------------------------------------------------
    private function current_raw_token()
    {
        $auth_header = $this->input->get_request_header('Authorization', true);
        if ($auth_header && stripos($auth_header, 'Bearer ') === 0) {
            return trim(substr($auth_header, 7));
        }

        $custom_header = $this->input->get_request_header('X-Api-Token', true);
        if ($custom_header) {
            return trim($custom_header);
        }

        return $this->input->post('token') ?: $this->input->get('token');
    }

    private function authenticate()
    {
        $token = $this->current_raw_token();
        if (empty($token)) {
            $this->fail('Missing API token.', 401);
            return false;
        }

        $token_hash = hash('sha256', $token);
        $this->db->select('api_tokens.id as token_id, users.id, users.name, users.email, users.role_id, users.status');
        $this->db->from('api_tokens');
        $this->db->join('users', 'users.id = api_tokens.user_id');
        $this->db->where('api_tokens.token_hash', $token_hash);
        $row = $this->db->get()->row_array();

        if (!$row || $row['status'] != 1 || $row['role_id'] != 3) {
            $this->fail('Invalid or expired token.', 401);
            return false;
        }

        $this->db->where('id', $row['token_id']);
        $this->db->update('api_tokens', ['last_used_at' => time()]);

        $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($row['id']);
        if (empty($restaurant_ids)) {
            $this->fail('No approved restaurant found for this account.', 403);
            return false;
        }

        $this->api_restaurant = $this->db->get_where('restaurants', ['id' => $restaurant_ids[0]])->row_array();
        return true;
    }

    // ---------------------------------------------------------------
    // GET api/ping — no auth, lets the app validate a server URL first
    // ---------------------------------------------------------------
    public function ping()
    {
        $this->respond(['success' => true, 'app' => 'fooyesco', 'time' => time()]);
    }

    // ---------------------------------------------------------------
    // POST api/login  { email, password, device_name? }
    // ---------------------------------------------------------------
    public function login()
    {
        if ($this->input->method() !== 'post') {
            return $this->fail('POST required.', 405);
        }

        $email = trim((string) $this->input->post('email'));
        $password = (string) $this->input->post('password');

        if ($email === '' || $password === '') {
            return $this->fail('Email and password are required.', 400);
        }

        $user = $this->db->get_where('users', [
            'email' => $email,
            'password' => sha1($password),
            'status' => 1,
        ])->row_array();

        if (!$user) {
            return $this->fail('Invalid email or password.', 401);
        }

        if ($user['role_id'] != 3) {
            return $this->fail('Only restaurant owner accounts can sign in to this app.', 403);
        }

        $this->issue_token_for_user($user, sanitize((string) $this->input->post('device_name')));
    }

    // ---------------------------------------------------------------
    // GET api/dev-token?email=owner@example.com — LOCAL TESTING ONLY.
    // Issues a real token for an owner account without a password, so the
    // API can be curl'd/tested directly. Only responds when the request
    // host contains ".local" (i.e. never on a real deployed domain) —
    // login()/authenticate() above are untouched by this.
    // ---------------------------------------------------------------
    public function dev_token()
    {
        $host = strtolower($_SERVER['HTTP_HOST'] ?? '');
        if (strpos($host, '.local') === false) {
            show_404();
            return;
        }

        $email = trim((string) $this->input->get('email'));
        if ($email === '') {
            return $this->fail('Pass ?email=owner@example.com to identify which account to issue a token for.', 400);
        }

        $user = $this->db->get_where('users', ['email' => $email, 'status' => 1])->row_array();
        if (!$user) {
            return $this->fail('No active user found with that email.', 404);
        }
        if ($user['role_id'] != 3) {
            return $this->fail('Only restaurant owner accounts can use this app.', 403);
        }

        $this->issue_token_for_user($user, 'dev-token (.local testing)');
    }

    // Shared by login() and dev_token() — resolves the owner's restaurant,
    // issues + stores a new token, and sends the standard login response.
    private function issue_token_for_user($user, $device_name)
    {
        $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($user['id']);
        if (empty($restaurant_ids)) {
            return $this->fail('No approved restaurant found for this account.', 403);
        }
        $restaurant = $this->db->get_where('restaurants', ['id' => $restaurant_ids[0]])->row_array();

        $token = bin2hex(random_bytes(32));
        $this->db->insert('api_tokens', [
            'user_id' => $user['id'],
            'token_hash' => hash('sha256', $token),
            'device_name' => $device_name,
            'created_at' => time(),
        ]);

        $this->respond([
            'success' => true,
            'token' => $token,
            'owner' => ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']],
            'restaurant' => ['id' => $restaurant['id'], 'name' => $restaurant['name']],
        ]);
    }

    // ---------------------------------------------------------------
    // POST api/logout
    // ---------------------------------------------------------------
    public function logout()
    {
        if (!$this->authenticate()) return;

        $this->db->where('token_hash', hash('sha256', $this->current_raw_token()));
        $this->db->delete('api_tokens');
        $this->respond(['success' => true]);
    }

    // ---------------------------------------------------------------
    // GET api/orders?status=pending,approved&limit=50&date_from=YYYY-MM-DD&date_to=YYYY-MM-DD
    // ---------------------------------------------------------------
    public function orders()
    {

        if (!$this->authenticate()) return;

        $status_param = $this->input->get('status');
        $statuses = $status_param ? array_filter(array_map('trim', explode(',', $status_param))) : [];
        $limit = (int) $this->input->get('limit');
        if ($limit <= 0 || $limit > 2000) $limit = 50;

        $date_from = $this->valid_date($this->input->get('date_from'));
        $date_to = $this->valid_date($this->input->get('date_to'));
        $order_type = nuller(sanitize($this->input->get('order_type')));
        $payment_method = nuller(sanitize($this->input->get('payment_method')));

        $rows = $this->order_model->api_get_orders($this->api_restaurant['id'], $statuses, $limit, $date_from, $date_to, $order_type, $payment_method);
        $this->respond([
            'success' => true,
            'restaurant' => ['id' => $this->api_restaurant['id'], 'name' => $this->api_restaurant['name']],
            'orders' => array_map([$this, 'summarize_order'], $rows),
        ]);
    }

    private function valid_date($value)
    {
        return (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) ? $value : null;
    }

    // ---------------------------------------------------------------
    // GET api/orders/{code}
    // ---------------------------------------------------------------
    public function order_detail($order_code)
    {
        if (!$this->authenticate()) return;

        $order = $this->order_model->api_get_order($order_code, $this->api_restaurant['id']);
        if (!$order) {
            return $this->fail('Order not found.', 404);
        }

        $data = $this->summarize_order($order);
        $data['items'] = $this->order_model->api_get_order_items($order_code);
        $data['billing'] = $this->decode_json_field($order['billing']);
        $data['address'] = $this->decode_json_field($order['address']);
        $data['timestamps'] = [
            'placed_at' => $order['order_placed_at'],
            'approved_at' => $order['order_approved_at'],
            'preparing_at' => $order['order_preparing_at'],
            'prepared_at' => $order['order_prepared_at'],
            'delivered_at' => $order['order_delivered_at'],
            'canceled_at' => $order['order_canceled_at'],
        ];

        // Same figures the printed receipt shows (application/views/backend/owner/orders/print_receipt_v2.php),
        // surfaced here too so the desktop app's on-screen popup can match it without printing.
        $data['is_online_discount'] = $order['is_online_discount'];
        $data['carry_bag_charge'] = $order['order_type'] !== 'pos' ? $this->cart_model->get_bag_charges() : 0;
        $data['service_charge'] = $order['order_type'] !== 'pos' ? $this->cart_model->get_service_amount() : 0;
        $data['payment_method'] = $this->order_model->api_get_order_payment_method($order_code);
        $data['restaurant_name'] = $this->api_restaurant['name'];

        $this->load->model('refund_model');
        $data['refund_request'] = $this->refund_model->api_get_status_for_order($order_code);

        $this->respond(['success' => true, 'order' => $data]);
    }

    // ---------------------------------------------------------------
    // GET api/orders/{code}/receipt?token=XXX — renders the SAME printable
    // receipt view the web app uses (Orders::print_recipt()), just
    // token-authenticated instead of session-authenticated, so the desktop
    // app can load this page directly instead of keeping its own duplicate
    // receipt template in sync by hand.
    // ---------------------------------------------------------------
    public function order_receipt($order_code)
    {
        if (!$this->authenticate()) return;

        $order = $this->order_model->api_get_order($order_code, $this->api_restaurant['id']);
        if (!$order) {
            show_404();
            return;
        }

        // Same data shape as Orders::print_recipt() (application/controllers/Orders.php).
        $order_details = $this->order_model->get_by_code($order_code);
        $data['order_details'] = $order_details;
        $data['ordered_items'] = $this->order_model->details($order_code);
        $data['payment'] = $this->order_model->get_order_payment($order_code);
        $data['daily_order_number'] = $order_details['daily_order_number'];

        $compare_date = strtotime('2026-04-08 00:00:00');
        if ((int) $order_details['order_placed_at'] < $compare_date) {
            $this->load->view('backend/owner/orders/print_receipt', $data);
        } else {
            $this->load->view('backend/owner/orders/print_receipt_v2', $data);
        }
    }

    // ---------------------------------------------------------------
    // POST api/orders/{code}/status   { phase: approved|preparing|prepared|delivered }
    // ---------------------------------------------------------------
    public function order_status($order_code)
    {
        if (!$this->authenticate()) return;

        if (!can_process_order()) {
            return $this->fail('Owner order processing is disabled in system settings. Ask your admin to enable it.', 403);
        }

        $phase = trim((string) $this->input->post('phase'));
        if ($phase === '') {
            return $this->fail('Phase is required.', 400);
        }

        // Mirrors the web flow: mark seen (clears the missed-order flag too), then advance status.
        $this->order_model->api_mark_read($order_code, $this->api_restaurant['id']);
        $result = $this->order_model->api_process_order($order_code, $phase, $this->api_restaurant['id']);

        $this->respond($result, $result['success'] ? 200 : 422);
    }

    // ---------------------------------------------------------------
    // POST api/orders/{code}/cancel
    // ---------------------------------------------------------------
    public function order_cancel($order_code)
    {
        if (!$this->authenticate()) return;

        $order = $this->order_model->api_get_order($order_code, $this->api_restaurant['id']);
        if (!$order) {
            return $this->fail('Order not found.', 404);
        }

        $this->order_model->api_mark_read($order_code, $this->api_restaurant['id']);
        $ok = $this->order_model->cancel($order_code);

        if ($ok) {
            $this->respond(['success' => true, 'message' => 'Order canceled.', 'order_status' => 'canceled']);
        } else {
            $this->respond(['success' => false, 'message' => 'Order can only be canceled while pending or approved.'], 422);
        }
    }

    // ---------------------------------------------------------------
    // GET api/stats — today's order count/revenue, live pending count, and
    // a 7-day daily breakdown for a simple chart.
    // ---------------------------------------------------------------
    public function stats()
    {
        if (!$this->authenticate()) return;

        $data = $this->order_model->api_get_stats($this->api_restaurant['id']);
        $this->respond(['success' => true] + $data);
    }

    // ---------------------------------------------------------------
    // GET api/stats/breakdown?dimension=month|domain|order_type|payment_method
    // ---------------------------------------------------------------
    public function stats_breakdown()
    {
        if (!$this->authenticate()) return;

        $dimension = $this->input->get('dimension');
        if (!in_array($dimension, ['month', 'domain', 'order_type', 'payment_method'], true)) {
            return $this->fail('Invalid or missing dimension.', 400);
        }

        $rows = $this->order_model->api_get_stats_breakdown($this->api_restaurant['id'], $dimension);
        $this->respond(['success' => true, 'dimension' => $dimension, 'breakdown' => $rows]);
    }

    // ---------------------------------------------------------------
    // GET/POST api/restaurant/status — "open for orders" toggle.
    // GET returns the current status; POST updates it.
    // POST body: unavailable=0|1, unavailable_text=string
    // ---------------------------------------------------------------
    public function restaurant_status()
    {
        if (!$this->authenticate()) return;

        if ($this->input->method() === 'post') {
            $unavailable = $this->input->post('unavailable') ? 1 : 0;
            $text = trim((string) $this->input->post('unavailable_text'));
            $this->restaurant_model->api_update_status($this->api_restaurant['id'], $unavailable, $text);
        }

        $status = $this->restaurant_model->api_get_status($this->api_restaurant['id']);
        $this->respond([
            'success' => true,
            'open' => empty($status['unavailable_on_fooyes']),
            'unavailable_text' => $status['unavailable_fooyes_text'] ?? '',
        ]);
    }

    // ---------------------------------------------------------------
    // GET/POST api/restaurant/hours — weekly opening hours.
    // POST body per day, e.g. monday_closed=1|0, monday_open=HH:MM, monday_close=HH:MM
    // ---------------------------------------------------------------
    public function restaurant_hours()
    {
        if (!$this->authenticate()) return;

        $days_order = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        if ($this->input->method() === 'post') {
            $days = [];
            foreach ($days_order as $day) {
                $days[$day] = [
                    'closed' => (bool) $this->input->post($day . '_closed'),
                    'open' => (string) $this->input->post($day . '_open'),
                    'close' => (string) $this->input->post($day . '_close'),
                ];
            }
            $this->restaurant_model->api_update_hours($this->api_restaurant['id'], $days);
        }

        $row = $this->restaurant_model->get_timings_by_id($this->api_restaurant['id']) ?: [];
        $hours = [];
        foreach ($days_order as $day) {
            $hours[$day] = [
                'closed' => !empty($row[$day . '_closed']),
                'open' => $row[$day . '_open'] ?? null,
                'close' => $row[$day . '_close'] ?? null,
            ];
        }

        $this->respond(['success' => true, 'hours' => $hours]);
    }

    // ---------------------------------------------------------------
    // GET api/refunds — this restaurant's refund requests.
    // ---------------------------------------------------------------
    public function refunds()
    {
        if (!$this->authenticate()) return;

        $this->load->model('refund_model');
        $rows = $this->refund_model->api_get_by_restaurant($this->api_restaurant['id']);

        $refunds = array_map(function ($r) {
            return [
                'order_code' => $r['order_code'],
                'refund_amount' => $r['refund_amount'],
                'status' => (int) $r['status'], // 0 pending, 1 accepted, 2 rejected
                'requested_at' => $r['requestedAt'],
                'accepted_at' => $r['acceptedAt'],
                'rejected_at' => $r['rejectedAt'],
            ];
        }, $rows);

        $this->respond(['success' => true, 'refunds' => $refunds]);
    }

    // ---------------------------------------------------------------
    // POST api/orders/{order_code}/request-refund — the OWNER requests a
    // refund (mirrors the "Request Refund" button on owner_report.php).
    // Approval/rejection is an ADMIN-only action (RefundRequest controller,
    // admin/refund/index.php) — deliberately NOT exposed here, since an
    // owner's own API token must never be able to approve its own request.
    // ---------------------------------------------------------------
    public function order_request_refund($order_code)
    {
        if (!$this->authenticate()) return;

        $this->load->model('refund_model');
        $result = $this->refund_model->api_request_refund($order_code, $this->api_restaurant['id']);

        if ($result['ok']) {
            $this->respond(['success' => true, 'message' => 'Refund requested.']);
        } else {
            $this->respond(['success' => false, 'message' => $result['message']], 422);
        }
    }

    // ---------------------------------------------------------------
    // INTERNAL HELPERS
    // ---------------------------------------------------------------
    private function decode_json_field($value)
    {
        if (empty($value)) return null;
        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }

    private function summarize_order($row)
    {
        $billing = $this->decode_json_field($row['billing'] ?? null);
        $customer_name = trim((($billing['first_name'] ?? '') . ' ' . ($billing['last_name'] ?? '')));
        $customer_phone = $billing['phone_mobile'] ?? '';

        if ($customer_name === '') {
            $user = $this->db->get_where('users', ['id' => $row['customer_id']])->row_array();
            $customer_name = $user['name'] ?? 'Guest';
            $customer_phone = $user['phone'] ?? '';
        }

        return [
            'id' => $row['id'],
            'code' => $row['code'],
            'order_status' => $row['order_status'],
            'order_type' => $row['order_type'],
            'grand_total' => $row['grand_total'],
            'total_menu_price' => $row['total_menu_price'],
            'total_delivery_charge' => $row['total_delivery_charge'],
            'total_vat_amount' => $row['total_vat_amount'],
            'promo_discount' => $row['promo_discount'],
            'note' => $row['note'],
            'order_placed_at' => $row['order_placed_at'],
            'read_status' => (string) $row['read_status'] === '1',
            'is_paid' => (string) $row['is_status'] === '1',
            'promo_code' => $row['promo_code'],
            'item_count' => isset($row['item_count']) ? (int) $row['item_count'] : null,
            'daily_order_number' => $row['daily_order_number'],
            'customer_name' => $customer_name,
            'customer_phone' => $customer_phone,
            'payment_method' => $row['payment_method'] ?? null,
            'address' => $this->decode_json_field($row['address'] ?? null),
        ];
    }
}
