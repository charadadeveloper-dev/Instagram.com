<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Painel Admin - Desbanir IP</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Courier New', Courier, monospace;
    }
    body {
      background-color: #0f0f0f;
      color: #00ff9f;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    .container {
      width: 100%;
      max-width: 500px;
      background: #151515;
      border: 1px solid #00ff9f;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px #00ff9f55;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #00ffaa;
      text-shadow: 0 0 5px #00ffaa;
    }
    #loginForm input {
      width: 100%;
      padding: 10px;
      background: #000;
      border: 1px solid #00ff9f;
      color: #00ff9f;
      border-radius: 5px;
      margin-bottom: 10px;
    }
    #loginForm button {
      width: 100%;
      padding: 10px;
      background: #00ff9f;
      border: none;
      color: #000;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    #adminPanel { display: none; }
    .ip-list {
      margin-top: 20px;
    }
    .ip-entry {
      display: flex;
      justify-content: space-between;
      background: #1a1a1a;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
      align-items: center;
    }
    .ip-entry button {
      background: red;
      color: white;
      border: none;
      padding: 5px 8px;
      border-radius: 3px;
      cursor: pointer;
    }
    .clear-all {
      margin-top: 20px;
      background: #444;
      border: 1px solid #00ff9f;
      color: #00ff9f;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
    }
    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 12px;
      color: #444;
    }
  </style>
</head>
<body>
  <div class="container">
    <div id="loginForm">
      <h2>Login Admin</h2>
      <input type="password" id="passwordInput" placeholder="Digite a senha..." />
      <button onclick="eval(atob('KGZ1bmN0aW9uKCl7Y29uc3Qgc2VuYT0nZmVybmFuZG9hZG1pbicscz1kb2N1bWVudC5nZXRFbGVtZW50QnlJZCgncGFzc3dvcmRJbnB1dCcpLnZhbHVlO2lmKHM9PT1zZW5hKXtkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9naW5Gb3JtJykuc3R5bGUuZGlzcGxheT0nbm9uZSc7ZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2FkbWluUGFuZWwnKS5zdHlsZS5kaXNwbGF5PSdibG9jayc7Y2FyZ2FyRGFkb3MoKX1lbHNle2FsZXJ0KCfDoSBzZW5oYScpfX0pKCk='))">Entrar</button>
    </div>

    <div id="adminPanel">
      <h2>IPs Banidos</h2>
      <div class="ip-list" id="ipList"></div>
      <button class="clear-all" onclick="clearAll()">Desbanir Todos</button>
      <div class="footer">Painel criado por Charada</div>
    </div>
  </div>

  <script>
    function carregarDados() {
      const list = JSON.parse(localStorage.getItem("bannedIPs") || "[]");
      const ipList = document.getElementById("ipList");
      ipList.innerHTML = "";

      if (list.length === 0) {
        ipList.innerHTML = "<p>Nenhum IP banido.</p>";
        return;
      }

      list.forEach(ip => {
        const div = document.createElement("div");
        div.className = "ip-entry";
        div.innerHTML = `
          <span>${ip}</span>
          <button onclick="desbanir('${ip}')">Desbanir</button>
        `;
        ipList.appendChild(div);
      });
    }

    function desbanir(ip) {
      let list = JSON.parse(localStorage.getItem("bannedIPs") || "[]");
      list = list.filter(item => item !== ip);
      localStorage.setItem("bannedIPs", JSON.stringify(list));
      carregarDados();
    }

    function clearAll() {
      if (confirm("Tem certeza que deseja desbanir todos os IPs?")) {
        localStorage.removeItem("bannedIPs");
        carregarDados();
      }
    }
  </script>

<?php
$ips = json_decode(file_get_contents("api/ips.json"), true);
foreach ($ips as $ip) {
  echo "<div style='margin:10px;padding:10px;border:1px solid red;'>
          <strong>$ip</strong>
          <form method='POST' action='api/desbanir.php' style='display:inline'>
            <input type='hidden' name='ip' value='$ip'>
            <button type='submit'>Desbanir</button>
          </form>
        </div>";
}
?>

</body>
</html>