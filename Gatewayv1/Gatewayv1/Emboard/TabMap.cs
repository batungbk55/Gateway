/********************************************************************************
 * Tên dự án        : Emboard
 * Nhóm thực hiện   : Sigate
 * Phòng nghiên cứu : Hệ nhúng nối mạng
 * Trường           : Đại Học Bách Khoa Hà Nội
 * Mô tả chung      : 1. Chương trình thu thập dữ liệu nhiệt độ, độ ẩm từ các sensor 
 *                    2. Ra quyết định điều khiển đến các actor phục vụ chăm sóc lan và cảnh báo cháy rừng
 *                    3. Chuyển tiếp dữ liệu về Web server để quản lý và theo dõi qua internet
 * IDE              : Microsoft Visual Studio 2008
 * Target Platform  : Window CE Device
 * *****************************************************************************/
#define ACTOR_BAOCHAY

using System;
using System.Windows.Forms;
using System.Drawing;
using System.IO;
using System.Xml;
using System.Threading;
using System.Net;

namespace Emboard
{
    public partial class Emboard : Form
    {
        libDraw drawImage = new libDraw();
        //**************************************************
        private const int WIDTH = 20;
        private const int HEIGHT = 20;
        //***************************************************
        private int pixel_x;
        private int pixel_y;
        //****************************************************
        private int id;
        private string status;
        //****************************************************
        private void Emboard_Load(object sender,EventArgs e)
        {
            Database db = new Database();
            comPort.pic = pictureBox1;
            db.setAllFalse();
            txtmac.Hide();
            pnShow.Hide();
            btexit.Enabled = true;
            comPort.txtShowData = tbShow;
            comPort.TimerInit();
            comPort.Time_control = db.getTimeActor();
            comPort.Time_alarm = db.getTimeAlarm();
            db.setFalseBC();
            db.setValOff();
            db.setAllFalse();
#if ACTOR_BAOCHAY
            cbMalenh.Items.Clear();
            cbMalenh.Items.Add("Lay nhiet do, do am");
            for (int i = 1; i < 6; i++)
            {
                cbMalenh.Items.Add("Gui canh bao muc "+i);
            }
#else
            cbMalenh.Items.Clear();
            cbMalenh.Items.Add("Lay nhiet do, do am");
            for (int i = 1; i < 7; i++)
            {
                cbMalenh.Items.Add("Bat van so "+i);
            }
            cbMalenh.Items.Add("Bat tat ca cac van");
            for (int i = 1; i < 7; i++)
            {
                cbMalenh.Items.Add("Tat van so " + i);
            }
            cbMalenh.Items.Add("Tat tat ca cac van");
#endif
            try
                {
                    drawImage.pictureBox = pictureBox1;
                    drawImage.reload(drawImage.pictureBox);
                }
                catch
                {
                    MessageBox.Show("Khong the load ban do");
                }
        }

        private void pictureBox1_MouseDown(object sender, MouseEventArgs e)
        {
            try
            {
                Database myDatabase = new Database();
                bool check = false;
#if ACTOR_BAOCHAY
                XmlNodeList node = (myDatabase.xml_bc).GetElementsByTagName("node");
#else
                XmlNodeList node = (myDatabase.xml).GetElementsByTagName("node");
#endif
                foreach (XmlNode nodechild in node)
                {
                    pixel_x = Int32.Parse(nodechild.Attributes["pixel_x"].Value);
                    pixel_y = Int32.Parse(nodechild.Attributes["pixel_y"].Value);
                    actor.Mac = nodechild.Attributes["mac"].Value;
                    status = nodechild.Attributes["status"].Value;
                    if (e.Button == MouseButtons.Right && e.X > pixel_x && e.X < pixel_x + WIDTH && e.Y > pixel_y && e.Y < pixel_y + HEIGHT)
                    {
                        if (actor.Mac == "00")
                        {
                            if (status == "true" || status == "True")
                            {
                                battatca.Enabled = true;
                                MNstatusA.Enabled = true;
                                tattatca.Enabled = true;
                            }
                            else
                            {
                                battatca.Enabled = false;
                                MNstatusA.Enabled = false;
                                tattatca.Enabled = false;
                            }
                            MNstatusA.Text = "Trang thai : " + nodechild.Attributes["status"].Value;
                            ctMenuActor.Show(pictureBox1, new Point(e.X, e.Y));
                        }
                        else if (actor.Mac[0] == 'B')
                        {
                            if (status == "true" || status == "True")
                            {
                                mnReset.Enabled = true;
                            }
                            else
                            {
                                mnReset.Enabled = false;
                            }
                            ctxMenuReset.Show(pictureBox1, new Point(e.X, e.Y));
                        }
                        else
                        {
                            sensor.Ip = nodechild.Attributes["network_ip"].Value;
                            MNstatusS.Text = "Trang thai: " + nodechild.Attributes["status"].Value;
                            if (status == "true" || status == "True")
                            {
                                laydulieu.Enabled = true;
                                MNstatusS.Enabled = true;
                                menuTemp.Enabled = true;
                                menuHumi.Enabled = true;
                                menuTemp.Text = "Nhiet do: " + nodechild.Attributes["temperature"].Value + "°C";
                                menuHumi.Text = "Do am: " + nodechild.Attributes["humidity"].Value + "%";
                            }
                            else
                            {
                                menuTemp.Text = "Nhiet do:  0°C";
                                menuHumi.Text = "Do am: 0%";
                                laydulieu.Enabled = false;
                                MNstatusS.Enabled = false;
                                menuTemp.Enabled = false;
                                menuHumi.Enabled = false;
                            }
                            ctMenuSensor.Show(pictureBox1, new Point(e.X, e.Y));
                        }
                        check = true;
                        break;
                    }
                }
                if (!check)
                {
#if ACTOR_BAOCHAY
#else
                    XmlNodeList val = (myDatabase.xml).GetElementsByTagName("val");
                    status = myDatabase.getStatusActor("00");
                    foreach (XmlNode valchild in val)
                    {
                        pixel_x = Int32.Parse(valchild.Attributes["pixel_x"].Value);
                        pixel_y = Int32.Parse(valchild.Attributes["pixel_y"].Value);
                        if (e.Button == MouseButtons.Right && e.X > pixel_x && e.X < pixel_x + WIDTH && e.Y > pixel_y && e.Y < pixel_y + HEIGHT)
                        {
                            if (status == "true" || status == "True")
                            {
                                batvan.Enabled = true;
                                tatvan.Enabled = true;
                                MNstatusV.Enabled = true;
                            }
                            else
                            {
                                batvan.Enabled = false;
                                tatvan.Enabled = false;
                                MNstatusV.Enabled = false;
                            }
                            id = Int32.Parse(valchild.Attributes["id"].Value);
                            MNstatusV.Text = "Trang thai : " + valchild.Attributes["state"].Value;
                            ctMenuVan.Show(pictureBox1, new Point(e.X, e.Y));
                            break;
                        }
                    }
#endif
                }
            }
            catch { }
        }
        private void laydulieu_Click(object sender, System.EventArgs e)
        {
            try
            {
                sensor.Command = sensor.Ip + "000$";
                byte[]  commandbyte = comPort.ConvertTobyte(sensor.Command);
                comPort.writeByteData(commandbyte);
                comPort.DisplayData("(" + DateTime.Now + "): Gui lenh lay du lieu sensor:\r\nMa lenh: " + sensor.Command, tbShow);
            }
            catch
            {
            }
        }
        private void batvan_Click(object sender, EventArgs e)
        {
            try
            {
                Database myDatabase = new Database();
                actor.Ip = myDatabase.getNetworkIpActor("00");
                switch (id)
                {
                    case 1:
                        actor.Command = actor.Ip + "011$";
                        break;
                    case 2:
                        actor.Command = actor.Ip + "021$";
                        break;
                    case 3:
                        actor.Command = actor.Ip + "031$";
                        break;
                    case 4:
                        actor.Command = actor.Ip + "041$";
                        break;
                    case 5:
                        actor.Command = actor.Ip + "051$";
                        break;
                    case 6:
                        actor.Command = actor.Ip + "061$";
                        break;
                   default:
                        actor.Command = actor.Ip + "011$";
                        break;
                }
                comPort.DisplayData("(" + DateTime.Now + "): Gui lenh dieu khien actor\r\nMa lenh: " + actor.Command, tbShow);
                //commandbyte = comPort.ConvertTobyte(command);
                //comPort.WriteData(commandbyte);
                byte[] commandbyte = comPort.ConvertTobyte(actor.Command);
                comPort.writeByteData(commandbyte);
            }
            catch
            {
            }
        }
        private void tatvan_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database myDatabase = new Database();
                actor.Ip = myDatabase.getNetworkIpActor("00");
                switch (id)
                {
                    case 1:
                        actor.Command = actor.Ip + "010$";
                        break;
                    case 2:
                        actor.Command = actor.Ip + "020$";
                        break;
                    case 3:
                        actor.Command = actor.Ip + "030$";
                        break;
                    case 4:
                        actor.Command = actor.Ip + "040$";
                        break;
                    case 5:
                        actor.Command = actor.Ip + "050$";
                        break;
                    case 6:
                        actor.Command = actor.Ip + "060$";
                        break;
                     default:
                        actor.Command = actor.Ip + "010$";
                        break;
                }
                comPort.DisplayData("(" + DateTime.Now + "): Gui lenh dieu khien actor:\r\nMa lenh: " + actor.Command, tbShow);
                //commandbyte = comPort.ConvertTobyte(command);
                //comPort.WriteData(commandbyte);
                byte[] commandbyte = comPort.ConvertTobyte(actor.Command);
                comPort.writeByteData(commandbyte);
            }
            catch
            {
            }
        }
        private void battatca_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database myDatabase = new Database();
                actor.Ip = myDatabase.getNetworkIpActor("00");
                actor.Command = actor.Ip + "151$";
                comPort.DisplayData("(" + DateTime.Now + "): Gui lenh dieu khien actor:\r\nMa lenh: " + actor.Command, tbShow);
                byte[] commandbyte = comPort.ConvertTobyte(actor.Command);
                comPort.writeByteData(commandbyte);
            }
            catch
            {
            }
        }
        private void tattatca_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database myDatabase = new Database();
                actor.Ip = myDatabase.getNetworkIpActor("00");
                actor.Command = actor.Ip + "150$";
                //DisplayData(MessageType.Incoming, "Command " + command + " sent at: " + DateTime.Now + "\r\n", tbShow);
                comPort.DisplayData("(" + DateTime.Now + "): Gui lenh dieu khien actor:\r\nMa lenh: " + actor.Command, tbShow);
                byte[] commandbyte = comPort.ConvertTobyte(actor.Command);
                comPort.writeByteData(commandbyte);
            }
            catch
            {
            }
        }
        private void mnReset_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database mydatabase = new Database();
                actor.Ip = mydatabase.getNetworkIpActor("00");
                actor.Command = actor.Ip + "031$";
                byte[] commandbyte = comPort.ConvertTobyte(actor.Command);
                comPort.writeByteData(commandbyte);
            }
            catch
            {
            }
        }

        private void tabControl1_SelectedIndexChanged(object sender, EventArgs e)
        {
            //comPort.Index = tabControl1.SelectedIndex;
            if(tabControl1.SelectedIndex==1)
            {
                pnNode.Show();
                pnGeneral.Hide();
                pnthreshold.Hide();
                pnsetup.Hide();
                pnNode.Location=new Point(0,0);
                lbGeneral.Enabled = true;
                lbNode.Enabled = false;
                linkthreshold.Enabled = true;
                linksetup.Enabled = true;
                rbCreateNode.Checked = true;
                cbmac.Hide();
                txtmac.Show();
                btCreate.Text = "Create Node";

                cbSelectNode.SelectedIndex = -1;
                tbLatitude.Text = string.Empty;
                tbLongitude.Text = string.Empty;
                tbActor.Text = string.Empty;
                tbLatitude.ReadOnly = false;
                tbLongitude.ReadOnly = false;
                tbActor.ReadOnly = false;
                tbActor.Enabled = true;
                lbActor.Enabled = true;
                txtmac.Text = "";
            }
        }

        private void btshow_Click(object sender, System.EventArgs e)
        {
            //comPort.mypanel.Hide();
        }
    }

}