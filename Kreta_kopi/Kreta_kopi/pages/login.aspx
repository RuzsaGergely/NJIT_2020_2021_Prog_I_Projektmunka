<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="login.aspx.cs" Inherits="Kreta_kopi.pages.login" %>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta name="viewport" content="width=device-width" />
    <title>Kréta kopi - Login page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
</head>
<body>
    <div style="margin-left: 40%; margin-right: 40%; margin-top:2%;">
        <div class="card">
            <div class="card-body">
                <form id="form1" runat="server">
                    <div class="mb-3">
                        <label for="usernameField" class="form-label">Felhasználónév</label>
                        <input type="text" class="form-control" id="usernameField" runat="server"/>
                    </div>
                    <div class="mb-3">
                        <label for="passwordField" class="form-label">Jelszó</label>
                        <input type="password" class="form-control" id="passwordField" runat="server"/>
                    </div>
                    <asp:Button id="submitButton" OnClick="submitButton_Click" Text="Bejelentkezés" runat="server" class="btn btn-success"/>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>