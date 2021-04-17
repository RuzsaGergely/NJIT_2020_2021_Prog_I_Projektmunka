using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using MySql.Data;
using MySql.Data.MySqlClient;
using System.Diagnostics;

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
            bool valid_login = false;
            string connStr = "server=localhost;user=root;database=Osztalynaplo;port=3306;password=";
            MySqlConnection conn = new MySqlConnection(connStr);
            try
            {
                conn.Open();
                string sql = "SELECT felhasznalonev, jelszo FROM felhasznalok WHERE felhasznalonev='" + usernameField.Value + "'";
                MySqlCommand cmd = new MySqlCommand(sql, conn);
                MySqlDataReader rdr = cmd.ExecuteReader();

                while (rdr.Read())
                {
                    if (passwordField.Value == rdr[1].ToString())
                    {
                        valid_login = true;
                        break;
                    }
                }
                rdr.Close();
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex.ToString());
            }
            conn.Close();

            if (valid_login)
            {
                Session["auth_user"] = true;
                HttpContext.Current.Response.Redirect("dashboard.aspx");
            } else
            {
                Response.Redirect(Request.RawUrl);
            }
        }
    }
}