<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Fooyes Error Alert</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0;background:#f5f7fb;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f5f7fb;">
    <tr>
      <td align="center" style="padding:24px;">
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:600px; max-width:100%; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 6px 24px rgba(16,24,40,.08);">
          <tr>
            <td style="background:#0f172a; padding:24px 24px 20px 24px;">
              <table role="presentation" width="100%">
                <tr>
                  <td align="left" style="font-family:Arial,Helvetica,sans-serif; color:#e2e8f0; font-size:14px;">
                    <div style="font-size:12px; color:#94a3b8; letter-spacing:.04em; text-transform:uppercase;">System Alert</div>
                    <div style="margin-top:6px; font-size:20px; font-weight:700; color:#ffffff;">🚨 New Error in Fooyes</div>
                  </td>
                  <td align="right">
                    <span style="display:inline-block; padding:6px 10px; background:#fee2e2; color:#b91c1c; border-radius:999px; font-family:Arial,Helvetica,sans-serif; font-size:12px; font-weight:700;">
                      Severity: <?= htmlspecialchars($message['Severity'] ?? '') ?>
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td style="padding:24px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate; border-spacing:0 8px;">
                <tr>
                  <td style="width:140px; font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#64748b;">Message</td>
                  <td style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#0f172a; background:#f8fafc; padding:12px 14px; border-radius:10px;">
                    <?= nl2br(htmlspecialchars($message['Message'] ?? '')) ?>
                  </td>
                </tr>
                <tr>
                  <td style="width:140px; font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#64748b;">File</td>
                  <td style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#0f172a; background:#f8fafc; padding:12px 14px; border-radius:10px;">
                    <code style="font-family:Menlo,Consolas,Monaco,monospace; background:#e2e8f0; padding:2px 6px; border-radius:6px; font-size:12px;"><?= htmlspecialchars($message['Filepath'] ?? '') ?></code>
                  </td>
                </tr>
                <tr>
                  <td style="width:140px; font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#64748b;">Line</td>
                  <td style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#0f172a; background:#f8fafc; padding:12px 14px; border-radius:10px;">
                    <?= htmlspecialchars($message['Line'] ?? '') ?>
                  </td>
                </tr>
                <tr>
                  <td style="width:140px; font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#64748b;">Time</td>
                  <td style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#0f172a; background:#f8fafc; padding:12px 14px; border-radius:10px;">
                    <?= htmlspecialchars($message['Time'] ?? '') ?>
                  </td>
                </tr>
              </table>

              <div style="height:1px; background:#e5e7eb; margin:20px 0;"></div>

              <div style="font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#475569; line-height:1.6;">
                <strong>Next steps:</strong>
                <ol style="margin:8px 0 0 18px; padding:0;">
                  <li>Check server logs for stack traces.</li>
                  <li>Reproduce locally if possible.</li>
                  <li>Patch and deploy a fix.</li>
                </ol>
              </div>
            </td>
          </tr>

          <tr>
            <td style="background:#f8fafc; padding:16px 24px;">
              <table role="presentation" width="100%">
                <tr>
                  <td style="font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#94a3b8;">
                    You’re receiving this because error notifications are enabled for <strong>Fooyes</strong>.
                  </td>
                  <td align="right">
                    <a href="mailto:no-reply@fooyes.co.uk" style="font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#3b82f6; text-decoration:none;">Contact DevOps</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
