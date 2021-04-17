using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Kreta_kopi.pages
{
    public partial class dashboard : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!Session.IsNewSession && Session["auth_user"] != null)
            {
                HttpContext.Current.Response.Redirect("login.aspx");
            }
        }
    }
}