using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Kreta_kopi.pages
{
    public partial class login : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!Session.IsNewSession && Session["auth_user"] != null)
            {
                HttpContext.Current.Response.Redirect("http://www.google.com");
            }
        }

        public void submitButton_Click(Object sender, EventArgs e)
        {
            if(passwordField.Value == "12345" && usernameField.Value == "admin")
            {
                Session["auth_user"] = true;
                HttpContext.Current.Response.Redirect("http://www.google.com");
            } else
            {
                Response.Redirect(Request.RawUrl);
            }
        }
    }
}