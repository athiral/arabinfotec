<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">

  <title>Thank You | Arabinfotec – Digital Growth Partner</title>

  <link rel="icon" href="favicon.svg" type="image/svg+xml">
  <link rel="icon" href="img/favicon.png" type="image/png" sizes="32x32">

  <style>
    :root {
      --container: 1120px;
      --bg: #f6f8fb;
      --card: #ffffff;
      --text: #0f172a;
      --muted: #475569;
      --line: #e2e8f0;
      --accent3: #6b4fd3;
      --accent4: #d44a86;
      --shadow: 0 18px 46px rgba(15,23,42,.12);
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
      background:
        radial-gradient(1000px 520px at 18% 18%, rgba(107,79,211,.18), transparent 60%),
        radial-gradient(1000px 520px at 82% 25%, rgba(212,74,134,.14), transparent 62%),
        var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .container {
      max-width: var(--container);
      margin: 0 auto;
      padding: 18px;
      width: 100%;
    }

    main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 0;
    }

    .card {
      max-width: 620px;
      width: 100%;
      background: rgba(255,255,255,.9);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: 24px;
      padding: 48px 40px;
      text-align: center;
      box-shadow: var(--shadow);
      animation: slideUp .6s ease-out;
      position: relative;
      overflow: hidden;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(22px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .loader {
      position: absolute;
      top: 0;
      left: 0;
      height: 4px;
      width: 100%;
      background: linear-gradient(90deg, var(--accent3), var(--accent4));
    }

    .check {
      width: 74px;
      height: 74px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--accent3), var(--accent4));
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 34px;
      margin: 0 auto 22px;
      box-shadow: 0 18px 40px rgba(107,79,211,.35);
    }

    h1 {
      margin: 0 0 12px;
      font-size: 30px;
      letter-spacing: -0.02em;
    }

    p {
      margin: 0 0 26px;
      color: var(--muted);
      font-size: 16px;
      line-height: 1.6;
    }

    .redirect {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 22px;
      border-radius: 999px;
      background: rgba(107,79,211,.08);
      border: 1px solid rgba(107,79,211,.18);
      color: #4c3fb5;
      font-weight: 700;
      font-size: 14px;
      margin-bottom: 32px;
    }

    #seconds {
      font-size: 18px;
      font-variant-numeric: tabular-nums;
    }

    .steps {
      background: rgba(255,255,255,.7);
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 26px;
      text-align: left;
    }

    .steps h3 {
      margin: 0 0 14px;
      font-size: 16px;
      font-weight: 800;
    }

    .steps ul {
      margin: 0;
      padding-left: 20px;
      font-size: 14.5px;
      color: var(--muted);
    }

    .steps li {
      margin-bottom: 10px;
      line-height: 1.55;
    }

    footer {
      padding: 20px;
      text-align: center;
      font-size: 12px;
      color: var(--muted);
    }

    @media (max-width: 560px) {
      .card { padding: 40px 22px; }
      h1 { font-size: 24px; }
    }
  </style>

  <!-- Google Tag Manager -->
  <script>
    (function(w,d,s,l,i){
      w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
      var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
      j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
      f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NXTPW989');
  </script>
</head>

<body>
<noscript>
  <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXTPW989"
          height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

<div class="container" id="page" hidden>
  <main>
    <div class="card">
      <div class="loader" id="loader"></div>

      <div class="check">✓</div>

      <h1>Thanks — Your Request Is Confirmed</h1>

      <p>
        We’ve successfully received your enquiry.
        Our team at <strong>Arabinfotec</strong> is reviewing your requirements and
        will reach out shortly to discuss the best digital growth approach for your business.
      </p>

      <div class="redirect">
        Redirecting you in <span id="seconds">8</span> seconds…
      </div>

      <div class="steps">
        <h3>What Happens Next?</h3>
        <ul>
          <li><strong>Business Review:</strong> We evaluate your goals, market, and current digital setup.</li>
          <li><strong>Expert Connect:</strong> A specialist will contact you via WhatsApp or email.</li>
          <li><strong>Growth Roadmap:</strong> You’ll receive a clear plan covering leads, systems, and scalability.</li>
        </ul>
      </div>
    </div>
  </main>

  <footer>
    © <span id="year"></span> Arabinfotec. All rights reserved.
  </footer>
</div>

<script>
(function () {
  const allowedDomains = ["arabinfotec.com", "arabinfotechllc.com"];
  const referrerValid = allowedDomains.some(d => document.referrer.includes(d));
  const isLocal = location.hostname === "localhost" || location.hostname === "127.0.0.1";

  if (!referrerValid && !isLocal) {
    location.href = "index.php";
    return;
  }

  document.getElementById("page").hidden = false;
  document.getElementById("year").textContent = new Date().getFullYear();

  let remaining = 8;
  const total = 8;
  const secondsEl = document.getElementById("seconds");
  const loader = document.getElementById("loader");
  const target = "https://arabinfotec.com/";

  const timer = setInterval(() => {
    remaining--;
    secondsEl.textContent = remaining;
    loader.style.width = (remaining / total) * 100 + "%";

    if (remaining <= 0) {
      clearInterval(timer);
      location.href = isLocal ? "index.php" : target;
    }
  }, 1000);
})();
</script>

</body>
</html>
