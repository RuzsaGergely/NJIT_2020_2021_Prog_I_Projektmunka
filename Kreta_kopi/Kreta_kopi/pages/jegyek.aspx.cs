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
    public partial class jegyek : System.Web.UI.Page
    {
        public string connStr = "server=localhost;user=root;database=Osztalynaplo;port=3306;password=";

        protected void Page_Load(object sender, EventArgs e)
        {
            MySqlConnection conn = new MySqlConnection(connStr);
            try
            {
                conn.Open();
                string sql = "SELECT * FROM diakok";
                MySqlCommand cmd = new MySqlCommand(sql, conn);
                MySqlDataReader rdr = cmd.ExecuteReader();

                diak_lista.DataSource = rdr;
                diak_lista.DataTextField = "nev";
                diak_lista.Value = "id";
                diak_lista.DataBind();
                rdr.Close();
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex.ToString());
            }
            conn.Close();
        }

        public void getButton_Click(Object sender, EventArgs e)
        {
            //<option value="value">text</option>

        }
    }
}