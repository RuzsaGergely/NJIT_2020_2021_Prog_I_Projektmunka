<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="dashboard.aspx.cs" Inherits="Kreta_kopi.pages.dashboard" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta name="viewport" content="width=device-width" />
    <title>Kréta kopi - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Kréta Kopi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#">Főoldal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Jegyek</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tanórák</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tanulók</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.aspx">Kijelentkezés</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div style="margin-left: 10%; margin-right: 10%; margin-top:2%;">
        <div class="card">
            <div class="card-body">
                <%
                    for (int i = 0; i < 10; i++)
                    {
                        Response.Write("<p>" + i + "</p>");
                    }
                    %>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
