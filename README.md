# dokuwiki-plugin-qrcodephp

Small plugin based on original from: https://www.dokuwiki.org/plugin:qrcode2

- Set the alignment of the QR code by adding a space before/after the qr code data.
- Set the Pixels per point by adding a space with an integer after "QRCODE"

Example
----
```
<!-- no alignment with default 4 pixels per point -->
{{QRCODE>https://github.com/bennvan}}

<!-- Center aligned with PPP set to 8 -->
{{QRCODE 8> https://github.com/bennvan }}
```


Basic Syntax
----
```
{{QRCODE [pixelsPerPoint]>[Qrcode data]}}

```