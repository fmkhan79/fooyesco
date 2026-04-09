<?php 

$uk_time = new DateTime('now', new DateTimeZone('Europe/London'));
$current_time = $uk_time->format('H:i:s'); // add seconds to match DB format

$current_day  = strtolower($uk_time->format('l'));

$day_closed  = $timings[$current_day . '_closed'] ?? 0;
$open_time   = $timings[$current_day . '_open']   ?? null;
$close_time  = $timings[$current_day . '_close']  ?? null;

$is_closed_now = $day_closed
    || is_null($open_time)
    || is_null($close_time)
    || $current_time < $open_time
    || $current_time >= $close_time;

$isDay_closed = $day_closed
    && is_null($open_time)
    && is_null($close_time);

echo "<!-- Current Time: $current_time, Open Time: $open_time, Close Time: $close_time, Is Closed Now: " . ($is_closed_now ? 'Yes' : 'No') . " Day: $current_day -->";
  
?>

<!-- ======================== -->
<!-- Time-based Close Modal -->
<!-- ======================== -->
<?php if(isset($is_closed_now) && $is_closed_now): ?>
<style>
  .disable-text-summary{
  display: block !important;
}
.order-summery-box{
  opacity: 0.2 !important;
  pointer-events: none !important;
}

.timing-modal-close {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  backdrop-filter: blur(5px);
}

.timing-modal-close .timing-modal-content {
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  width: 400px;
  max-width: 90%;
  text-align: center;
}

.order.col-md-2.d-none.d-md-block,
.order.col-md-2.d-md-none {
    opacity: 0.2 !important;
    pointer-events: none !important;
}

</style>

<span id="disable-menu" style="display:none"></span>

<div class="timing-modal-close" id="timing-closed-modal">
  <div class="timing-modal-content">
    <h3>Restaurant is currently closed</h3>
    
    <?php if($isDay_closed): ?>
      <p>The restaurant is closed for the entire day.</p>
    <?php else: ?>
      <p>You can order between <?= date('g:i A', strtotime($open_time)) ?> and <?= date('g:i A', strtotime($close_time)) ?></p>
    <?php endif; ?>

      
    <a style="background-color: rgb(255, 77, 77); border-radius: 38px;border:0px; padding: 10px 30px;color:white" class="btn btn-primary" onclick="timingDeleteClosedModal()">View Menu</a>
  </div>
</div>
<?php endif; ?>

<script>
function timingDeleteModal() {
    const modal = document.getElementById('timing-unavailable-modal');
    if (modal) modal.remove();
}

function timingDeleteClosedModal() {
    const modal = document.getElementById('timing-closed-modal');
    if (modal) modal.remove();
}
</script>