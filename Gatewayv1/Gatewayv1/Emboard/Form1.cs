using System.Drawing;
using System.Windows.Forms;

namespace Emboard
{
    public partial class Emboard : Form
    {
        public Emboard()
        {
            InitializeComponent();
            btSend.Enabled = false;
            cbMalenh.Enabled = false;
            cbnode.Enabled = false;
            btDisconnect.Enabled = false;
            btexit.Enabled = false;
            pnGeneral.Visible = true;
            pnNode.Visible = false;
            pnGeneral.Location = new Point(0, 0);
            panel2.Visible = true;
            panel2.Controls.Add(pnGeneral);
        }

        public string[] messageList;
        public string strmsg;
        private void btnTestComclick(object sender, System.EventArgs e)
        {
            COM port = new COM();
            port.ReadSMS(port.COMSMS);
            #region Read SMS
            //.............................................. Read all SMS ....................................................
            ShortMessageCollection objShortMessageCollection = port.ReadSMS(port.COMSMS);
            //string[] strmsg;
            foreach (ShortMessage msg in objShortMessageCollection)
            {

                 messageList=new string[] { msg.Index, msg.Sent, msg.Sender, msg.Message };
                 strmsg = strmsg + messageList[0] + messageList[1] + messageList[2] + messageList[3]+"\n";
            }
            MessageBox.Show("SMS "+strmsg);
            #endregion
        }
    }
}