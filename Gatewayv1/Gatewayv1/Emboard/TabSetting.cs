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

using System;
using System.Windows.Forms;
using System.Drawing;
using System.Xml;
namespace Emboard
{
    public partial class Emboard : Form
    {
        public byte[] confixcmd = new byte[4] {255, 255, 0, 36};
        /************************************************************************
        ** Code panel Threshold 
        ************************************************************************/
        private void linkthreshold_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database myDatabase = new Database();
                lbNode.Enabled = true;
                lbGeneral.Enabled = true;
                linkthreshold.Enabled = false;
                linksetup.Enabled = true;

                pnGeneral.Visible = false;
                pnNode.Visible = false;
                pnthreshold.Visible = true;
                pnsetup.Visible = false;

                panel2.Visible = true;
                panel2.Controls.Add(pnthreshold);
                pnthreshold.Location = new Point(0, 0);
                txtTemThresh.Text = myDatabase.getTempMax().ToString();
                txtHumiThresh.Text = myDatabase.getHumiMax().ToString();
                txtPhoneThresh.Text = myDatabase.getPhoneNumber().ToString();
                cbSmokeThresh.SelectedIndex = -1;
                cbSelectVan.Items.Clear();
                XmlNodeList van = (myDatabase.xml).GetElementsByTagName("val");
                foreach (XmlNode idVan in van)
                {
                    string str = idVan.Attributes["id"].Value;
                    cbSelectVan.Items.Add("Van "+str);
                }
                cbSelectVan.SelectedIndex = 0;
                txtTemThresh.Text = myDatabase.getTempVan(1).ToString();
                txtHumiThresh.Text = myDatabase.getHumiVan(1).ToString();
            }
            catch { }
        }
        //Kiem tra cho du lieu nhiet do nhap vao textbox la so
        private void txtTemThresh_KeyPress(object sender, KeyPressEventArgs e)
        {
            char keycode = e.KeyChar;
            int c = (int)keycode;
            // Kiểm tra ký tự vừa nhập vào có phải là các số nằm trong khoảng
            // 0..9 hoặc ký tự "." hoặc "-" hoặc "Backspace"
            if ((c >= 48) && (c <= 57) || (c == 45) || (c == 46) || (c == 8))
            {
                e.Handled = false;
            }
            else
            {
                e.Handled = true;
                MessageBox.Show("Nhiet do chi duoc nhap ki tu so", "Thong bao");
            }
        }
        //Kiem tra cho du lieu do am nhap vao textbox la so
        private void txtHumiThresh_KeyPress(object sender, KeyPressEventArgs e)
        {
            char keycode = e.KeyChar;
            int c = (int)keycode;
            // Kiểm tra ký tự vừa nhập vào có phải là các số nằm trong khoảng
            // 0..9 hoặc ký tự "." hoặc "-" hoặc "Backspace"
            if ((c >= 48) && (c <= 57) || (c == 45) || (c == 46) || (c == 8))
            {
                e.Handled = false;
            }
            else
            {
                e.Handled = true;
                MessageBox.Show("Do am chi duoc nhap ki tu so", "Thong bao");
            }
        }
        //Kiem tra cho du lieu phonenumber nhap vao textbox la so
        private void txtPhoneThresh_KeyPress(object sender, KeyPressEventArgs e)
        {
            char keycode = e.KeyChar;
            int c = (int)keycode;
            // Kiểm tra ký tự vừa nhập vào có phải là các số nằm trong khoảng
            // 0..9 hoặc ký tự "." hoặc "-" hoặc "Backspace"
            if ((c >= 48) && (c <= 57) || (c == 8))
            {
                e.Handled = false;
            }
            else
            {
                e.Handled = true;
                MessageBox.Show("So dien thoai chi duoc nhap ki tu so", "Thong bao");
            }
        }

        private void cbSmokeThresh_SelectedIndexChanged(object sender, System.EventArgs e)
        {
            int val = 32 + cbSmokeThresh.SelectedIndex;
            confixcmd[2] = (byte)val;
        }
        private void cbSelectVan_SelectedIndexChanged(object sender, System.EventArgs e)
        {
        try
        {
            Database mydatabase = new Database();
            int id = cbSelectVan.SelectedIndex + 1;
            txtTemThresh.Text = mydatabase.getTempVan(id).ToString();
            txtHumiThresh.Text = mydatabase.getHumiVan(id).ToString();
        }
        catch{}
        }
        private void btapplythreshold_Click(object sender, System.EventArgs e)
        {
            try
            {
                if (txtTemThresh.Text != "" && txtHumiThresh.Text != "" && txtPhoneThresh.Text != "")
                {
                    Database myDatabase = new Database();
                    int id = cbSelectVan.SelectedIndex + 1;
                    int a = myDatabase.setTempVan(id,float.Parse(txtTemThresh.Text));
                    int b = myDatabase.setHumiVan(id,float.Parse(txtHumiThresh.Text));
                    int c = myDatabase.setPhoneNumber(txtPhoneThresh.Text);
                    if(a == 1 && b == 1 && c == 1)
                    {
                        MessageBox.Show("Save successful", "Imformation");
                    }
                    else
                    {
                        MessageBox.Show("Not successful","Imformation");
                    }
                }
                else
                {
                    MessageBox.Show("Not enough imformation", "Error");
                }
            }
            catch { }
        }
        private void btCancelThreshold_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database myDatabase = new Database();
                txtTemThresh.Text = myDatabase.getTempMax().ToString();
                txtHumiThresh.Text = myDatabase.getHumiMax().ToString();
                txtPhoneThresh.Text = myDatabase.getPhoneNumber().ToString();
                cbSmokeThresh.SelectedIndex = -1;
            }
            catch { }
        } 
        /************************************************************************
        ** Code panel General
        ************************************************************************/
        private void lbGeneral_Click(object sender, EventArgs e)
        {
            try
            {
                lbNode.Enabled = true;
                lbGeneral.Enabled = false;
                linkthreshold.Enabled = true;
                linksetup.Enabled = true;

                pnNode.Visible = false;
                pnGeneral.Visible = true;
                pnthreshold.Visible = false;
                pnsetup.Visible = false;
                panel2.Visible = true;
                panel2.Controls.Add(pnGeneral);
                pnGeneral.Location = new Point(0, 0);

                cbMode.SelectedIndex = 0;
                btApply.Enabled = true;
                btCancel.Enabled = true;
                lbsmoke.Hide();
                cbSmokeThresh.Hide();
                lbtimecontrol.Hide();
                cbtimecontrol.Hide();
                lbperiod.Hide();
                cbPeriod.Hide();
                lbalarm.Hide();
                cbalarm.Hide();
            }
            catch { }
        }

        private void cbMode_SelectedIndexChanged(object sender, System.EventArgs e)
        {
            try
            {
                Database myDatabase =  new Database();
                btApply.Enabled = true;
                btCancel.Enabled = true;
                if (cbMode.SelectedIndex == 0)
                {
                    lbsmoke.Hide();
                    cbSmokeThresh.Hide();
                    lbtimecontrol.Hide();
                    cbtimecontrol.Hide();
                    lbperiod.Hide();
                    cbPeriod.Hide();
                    lbalarm.Hide();
                    cbalarm.Hide();
                    confixcmd[2] = 1;
                }
                if (cbMode.SelectedIndex == 1)
                {
                    lbsmoke.Hide();
                    cbSmokeThresh.Hide();
                    lbtimecontrol.Hide();
                    cbtimecontrol.Hide();
                    cbPeriod.Show();
                    lbperiod.Show();
                    lbalarm.Hide();
                    cbalarm.Hide();
                    for (int i = 1; i < 17; i++)
                    {
                        cbPeriod.Items.Add(i * 5 + " minutes");
                    }
                }
                if (cbMode.SelectedIndex == 2)
                {
                    lbsmoke.Hide();
                    cbSmokeThresh.Hide();
                    lbtimecontrol.Show();
                    cbtimecontrol.Show();
                    lbperiod.Hide();
                    cbPeriod.Hide();
                    lbalarm.Hide();
                    cbalarm.Hide();
                    lbtimecontrol.Location = new Point(7, 91);
                    cbtimecontrol.Location = new Point(108, 91);
                    for (int i = 1; i < 31; i++) {
                        cbtimecontrol.Items.Add(i+" minutes");
                    }
                    cbtimecontrol.SelectedIndex = myDatabase.getTimeActor() - 1;
                }
                if (cbMode.SelectedIndex == 3)
                {
                    lbsmoke.Show();
                    cbSmokeThresh.Show();
                    lbtimecontrol.Hide();
                    cbtimecontrol.Hide();
                    lbperiod.Hide();
                    cbPeriod.Hide();
                    lbalarm.Hide();
                    cbalarm.Hide();
                    lbsmoke.Location = new Point(7,91);
                    cbSmokeThresh.Location =new Point (108, 91);
                }
                if (cbMode.SelectedIndex == 4)
                {
                    lbsmoke.Hide();
                    cbSmokeThresh.Hide();
                    lbtimecontrol.Hide();
                    cbtimecontrol.Hide();
                    lbperiod.Hide();
                    cbPeriod.Hide();
                    lbalarm.Show();
                    cbalarm.Show();
                    lbalarm.Location = new Point(7, 91);
                    cbalarm.Location = new Point(108, 91);
                    for (int i = 1; i < 25; i++)
                    {
                        cbalarm.Items.Add(5*i+" minutes");
                    }
                    cbalarm.SelectedIndex = myDatabase.getTimeAlarm()/5 -1;
                }
            }
            catch { }
        }  
        private void cbPeriod_SelectedIndexChanged(object sender, System.EventArgs e)
        {
            int value = 16 + cbPeriod.SelectedIndex + 1;
            confixcmd[2] = (byte)value;
            //MessageBox.Show(confixcmd[2].ToString());
        }

        private void btApply_Click(object sender, EventArgs e)
        {
            try
            {
                if(cbMode.SelectedIndex == 0)
                {
                        comPort.DisplayData("("+DateTime.Now+")Sensor chuyen sang che do thuc ngu!", tbShow);
                        comPort.writeByteData(confixcmd);
                        MessageBox.Show("Sent successful!", "Infomations");
                }
                if(cbMode.SelectedIndex == 1)
                {
                    if (cbPeriod.SelectedIndex != -1)
                    {
                            comPort.DisplayData("(" + DateTime.Now + ")Dieu chinh thoi gian gui du lieu dinh ky!", tbShow);
                            comPort.writeByteData(confixcmd);
                            MessageBox.Show("Sent successful!", "Infomations");
                        }
                        else
                        {
                            MessageBox.Show("Not enough imformation","Error");
                        }
                 }
                if (cbMode.SelectedIndex == 2)
                {
                    if (cbtimecontrol.SelectedIndex != -1)
                    {
                        Database myDatabase = new Database();
                        int value = cbtimecontrol.SelectedIndex + 1;
                        int a = myDatabase.setTimeActor(value);
                        if(a == 1)
                            MessageBox.Show("Save successful!", "Infomations");
                        comPort.Time_control = myDatabase.getTimeActor();
                    }
                    else
                    {
                        MessageBox.Show("Not enough imformation", "Error");
                    }
                }
                if (cbMode.SelectedIndex == 3)
                {
                    if (cbSmokeThresh.SelectedIndex != -1)
                    {
                        comPort.writeByteData(confixcmd);
                        comPort.DisplayData("(" + DateTime.Now + ")Thiet lap nong do nguong khoi", tbShow);
                        MessageBox.Show("Sent successful", "Imformation");
                    }
                    else
                    {
                        MessageBox.Show("Not enough imformation", "Error");
                    }
                }
                if (cbMode.SelectedIndex == 4)
                {
                    if (cbalarm.SelectedIndex != -1)
                    {
                        Database myDatabase = new Database();
                        int value = (cbalarm.SelectedIndex + 1)*5;
                        int a = myDatabase.setTimeAlarm(value);
                        if (a == 1)
                            MessageBox.Show("Save successful!", "Infomations");
                        comPort.Time_alarm = myDatabase.getTimeAlarm();
                    }
                    else
                    {
                        MessageBox.Show("Not enough imformation", "Error");
                    }
                }
                    
            }
            catch { }
        }

        private void btCancel_Click(object sender, EventArgs e)
        {
            try
            {
                cbMode.SelectedIndex = 0;
                lbsmoke.Hide();
                cbSmokeThresh.Hide();
                lbtimecontrol.Hide();
                cbtimecontrol.Hide();
                lbperiod.Hide();
                cbPeriod.Hide();
                lbalarm.Hide();
                cbalarm.Hide();
            }
            catch { }
        }
        /************************************************************************
       ** Code panel node
       ************************************************************************/
        private void lbNode_Click(object sender, EventArgs e)
        {
            try
            {
                lbNode.Enabled = false;
                lbGeneral.Enabled = true;
                linkthreshold.Enabled = true;
                linksetup.Enabled = true;
                pnGeneral.Visible = false;
                pnNode.Visible = true;
                pnthreshold.Visible = false;
                pnsetup.Visible = false;

                panel2.Visible = true;
                panel2.Controls.Add(pnNode);
                pnNode.Location = new Point(0, 0);
                rbCreateNode.Checked = true;
            }
            catch { }
        }
        //Kiem tra ki tu nhap vao Latitude co phai la so khong
        private void tbLatitude_KeyPress(object sender, KeyPressEventArgs e)
        {
            char keycode = e.KeyChar;
            int c = (int)keycode;
            // Kiểm tra ký tự vừa nhập vào có phải là các số nằm trong khoảng
            // 0..9 hoặc ký tự "." hoặc "-" hoặc "Backspace"
            if ((c >= 48) && (c <= 57) || (c == 45) || (c == 46) || (c == 8))
            {
                e.Handled = false;
            }
            else
            {
                e.Handled = true;
                MessageBox.Show("Latitude must input form number!", "Error");
            }
        }
        //Kiem tra ki tu nhap vao Longitude co phai la so khong
        private void tbLongitude_KeyPress(object sender, KeyPressEventArgs e)
        {
            char keycode = e.KeyChar;
            int c = (int)keycode;
            // Kiểm tra ký tự vừa nhập vào có phải là các số nằm trong khoảng
            // 0..9 hoặc ký tự "." hoặc "-" hoặc "Backspace"
            if ((c >= 48) && (c <= 57) || (c == 45) || (c == 46) || (c == 8))
            {
                e.Handled = false;
            }
            else
            {
                e.Handled = true;
                MessageBox.Show("Longitude must input form number!", "Error");
            }
        }
        private void rbCreateNode_Click(object sender, EventArgs e)
        {
            try
            {
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
                txtmac.Show();
                cbmac.Hide();
                btCreate.Text = "Create Node";
            }
            catch { }
        }

        private void rdeditnode_Click(object sender, System.EventArgs e)
        {
            try
            {
                cbSelectNode.SelectedIndex = -1;
                cbmac.Items.Clear();
                cbmac.Text = "";
                tbLatitude.Text = string.Empty;
                tbLongitude.Text = string.Empty;
                tbActor.Text = string.Empty;
                tbLatitude.ReadOnly = false;
                tbLongitude.ReadOnly = false;
                tbActor.ReadOnly = false;
                tbActor.Enabled = true;
                lbActor.Enabled = true;
                txtmac.Hide();
                cbmac.Show();
                btCreate.Text = "Edit Node";
            }
            catch { }
        }  
        private void rbDeleteNode_Click(object sender, EventArgs e)
        {
            try
            {
                cbSelectNode.SelectedIndex = -1;
                cbmac.Items.Clear();
                cbmac.Text = "";
                tbLatitude.Text = string.Empty;
                tbLongitude.Text = string.Empty;
                tbActor.Text = string.Empty;
                tbLatitude.ReadOnly = true;
                tbLongitude.ReadOnly = true;
                tbActor.ReadOnly = true;
                tbActor.Enabled = true;
                lbActor.Enabled = true;
                txtmac.Hide();
                cbmac.Show();
                btCreate.Text = "Delete Node";
            }
            catch { }
        }

        private void cbSelectNode_SelectedIndexChanged(object sender, EventArgs e)
        {
            try
            {
                cbSelectNode.DropDownStyle = ComboBoxStyle.DropDownList;
                tbLatitude.Text = string.Empty;
                tbLongitude.Text = string.Empty;
                tbActor.Text = string.Empty;
                int index = cbSelectNode.SelectedIndex;
                if (index == 0)
                {
                    cbmac.Items.Clear();
                    cbmac.Text = "";
                    tbActor.Enabled = true;
                    lbActor.Enabled = true;
                    Database my_Database = new Database();
                    XmlNodeList nodeSensor = ((XmlElement)my_Database.sensor).GetElementsByTagName("node");
                    foreach (XmlNode node in nodeSensor)
                    {
                        string str = node.Attributes["mac"].Value;
                        cbmac.Items.Add(str);
                    }
                }
                else
                {
                    cbmac.Items.Clear();
                    cbmac.Text = "";
                    tbActor.Enabled = false;
                    lbActor.Enabled = false;
                    Database my_Database = new Database();
                    XmlNodeList nodeActor = ((XmlElement)my_Database.actor).GetElementsByTagName("node");
                    foreach (XmlNode node in nodeActor)
                    {
                        string str = node.Attributes["mac"].Value;
                        cbmac.Items.Add(str);
                    }

                }
            }
            catch { }
        }

        private void cbmac_SelectedIndexChanged(object sender, EventArgs e)
        {
            try
            {
                Database my_Database = new Database();
                int index = cbSelectNode.SelectedIndex;
                if (index == 0)
                {
                    if (rbDeleteNode.Checked == true || rdeditnode.Checked == true)
                    {
                        string macSensor = cbmac.Text;
                        tbLatitude.Text = my_Database.getSensorPixel_x(macSensor).ToString();
                        tbLongitude.Text = my_Database.getSensorPixel_y(macSensor).ToString();
                        tbActor.Text = my_Database.getVanSensor(macSensor);
                    }
                }
                else
                {
                    string macActor = cbmac.Text;
                    tbLatitude.Text = my_Database.getActorPixel_x(macActor).ToString();
                    tbLongitude.Text = my_Database.getActorPixel_y(macActor).ToString();
                }
            }
            catch { }
        }
        private void btCreate_Click(object sender, EventArgs e)
        {
            try
            {
                Database my_Database = new Database();
                if (btCreate.Text == "Create Node")
                {
                        if (cbSelectNode.SelectedIndex == 0)
                        {
                            if (txtmac.Text != "" && tbLatitude.Text != "" && tbLongitude.Text != "" && tbActor.Text != "")
                            {
                                string mac = txtmac.Text;
                                int latitude = int.Parse(tbLatitude.Text);
                                int longitude = int.Parse(tbLongitude.Text);
                                string actor = tbActor.Text;
                                if (my_Database.CheckSensor(mac) == "true")
                                {
                                    int a = my_Database.setSensorPixel_x(mac, latitude);
                                    int b = my_Database.setSensorPixel_y(mac, longitude);
                                    int c = my_Database.setVanSensor(mac, actor);
                                    if (a == 1 && b == 1 && c == 1)
                                    {
                                        MessageBox.Show("Saved succeessful! ", "Informations");
                                    }
                                }
                                else
                                {
                                    int d = my_Database.setSensor(mac, latitude, longitude, actor);
                                    if (d == 1)
                                    {
                                        MessageBox.Show("Saved succeessful! ", "Informations");
                                    }
                                }
                            }
                            else
                            {
                                MessageBox.Show("Not enough informations!", "Error");
                            }
                        }
                        else
                        {
                            if (txtmac.Text != "" && tbLatitude.Text != "" && tbLongitude.Text != "")
                            {
                                string mac = txtmac.Text;
                                int latitude = int.Parse(tbLatitude.Text);
                                int longitude = int.Parse(tbLongitude.Text);
                                string actor = tbActor.Text;
                                if (my_Database.CheckActor(mac) == "true")
                                {
                                    int a = my_Database.setActorPixel_x(mac, latitude);
                                    int b = my_Database.setActorPixel_y(mac, longitude);
                                    if (a == 1 && b == 1)
                                    {
                                        MessageBox.Show("Saved succeessful! ", "Informations");
                                    }
                                }
                                else
                                {
                                    int d = my_Database.setActor(mac, latitude, longitude);
                                    if (d == 1)
                                    {
                                        MessageBox.Show("Saved succeessful! ", "Informations");
                                    }
                                }
                            }
                            else
                            {
                                MessageBox.Show("Not enough informations!", "Error");
                            }
                        }
                    }
                if (btCreate.Text == "Delete Node")
                {
                    if (cbmac.SelectedIndex != -1)
                    {
                        string mac = cbmac.Text;
                        DialogResult result = MessageBox.Show("Do you want to delete " + cbSelectNode.Text + " " + cbmac.Text + "?", "Warring",MessageBoxButtons.OKCancel,MessageBoxIcon.Question,MessageBoxDefaultButton.Button1);
                        if (result == DialogResult.OK)
                        {

                            if (cbSelectNode.SelectedIndex == 0)
                            {
                                int totalSensor = my_Database.getTotalSensor();
                                int a = my_Database.deleteSensor(mac);
                                if (a == 1)
                                {
                                    totalSensor--;
                                    my_Database.setTotalSensor(totalSensor);
                                    MessageBox.Show("Deleted succeessful! ", "Informations");
                                }
                                else
                                {
                                    MessageBox.Show("Deleted unsucceessful! ", "Informations");
                                }
                            }
                            else
                            {
                                int totalActor = my_Database.getTotalActor();
                                int a = my_Database.deleteActor(mac);
                                if (a == 1)
                                {
                                    totalActor--;
                                    my_Database.setTotalActor(totalActor);
                                    MessageBox.Show("Deleted succeessful!", "Informations");
                                }
                                else
                                {
                                    MessageBox.Show("Deleted unsucceessful!", "Informations");
                                }
                            }
                        }
                    }
                    else
                    {
                        MessageBox.Show("You must select node or MAC address!", "Error");
                    }
                }
                if (btCreate.Text == "Edit Node")
                {
                    if (cbSelectNode.SelectedIndex == 0)
                    {
                        if (cbmac.SelectedIndex != -1 && tbLatitude.Text != "" && tbLongitude.Text != "" && tbActor.Text != "")
                        {
                            string mac = cbmac.Text;
                            int latitude = int.Parse(tbLatitude.Text);
                            int longitude = int.Parse(tbLongitude.Text);
                            string actor = tbActor.Text;
                            int a = my_Database.setSensorPixel_x(mac, latitude);
                            int b = my_Database.setSensorPixel_y(mac, longitude);
                            int c = my_Database.setVanSensor(mac, actor);
                            if (a == 1 && b == 1 && c == 1)
                            {
                               MessageBox.Show("Saved succeessful! ", "Informations");
                             }
                        }
                        else
                        {
                            MessageBox.Show("Not enough informations!", "Error");
                        }
                    }
                    else
                    {
                        if (cbmac.SelectedIndex != -1 && tbLatitude.Text != "" && tbLongitude.Text != "")
                        {
                            string mac = cbmac.Text;
                            int latitude = int.Parse(tbLatitude.Text);
                            int longitude = int.Parse(tbLongitude.Text);
                            string actor = tbActor.Text;
                            int a = my_Database.setActorPixel_x(mac, latitude);
                            int b = my_Database.setActorPixel_y(mac, longitude);
                            if (a == 1 && b == 1)
                            {
                                MessageBox.Show("Saved succeessful! ", "Informations");
                             }
                        }
                        else
                        {
                            MessageBox.Show("Not enough informations!", "Error");
                        }
                    }
                }
                drawImage.reload(drawImage.pictureBox);
            }
            catch { }
        }
        /************************************************************
         * code panel setup
         * **********************************************************/
        private void linksetup_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database mydatabase = new Database();
                lbNode.Enabled = true;
                lbGeneral.Enabled = true;
                linkthreshold.Enabled = true;
                linksetup.Enabled = false;

                pnGeneral.Visible = false;
                pnNode.Visible = false;
                pnthreshold.Visible = false;
                pnsetup.Visible = true;
                cbSetupFinish.Items.Clear();
                for (int i = 0; i < 24; i++)
                {
                    cbSetupBegin.Items.Add(i + " h");
                }
                cbSetupBegin.Text = mydatabase.getTimeStart().ToString() + " h";
                int index = mydatabase.getTimeStart() + 1;
                for (int i = index; i < 24; i++)
                {
                    cbSetupFinish.Items.Add(i + " h");
                }
                cbSetupFinish.Text = mydatabase.getTimeFinish().ToString() + " h";
            }
            catch { }

        }

        private void cbSetupBegin_SelectedIndexChanged(object sender, System.EventArgs e)
        {
            try
            {
                cbSetupFinish.Text = "";
                cbSetupFinish.Items.Clear();
                int index = cbSetupBegin.SelectedIndex;
                for (int i = index + 1; i < 24; i++)
                {
                    cbSetupFinish.Items.Add(i + " h");
                }
            }
            catch { }
        }

        private void btSetupApply_Click(object sender, System.EventArgs e)
        {
            try
            {
                if (cbSetupBegin.SelectedIndex == -1 || cbSetupFinish.SelectedIndex == -1)
                {
                    MessageBox.Show("Not enough imformations","Imformation");
                }
                else
                {
                    Database mydatabase = new Database();
                    string h = cbSetupFinish.Text;
                    string[] hour = h.Split(new char[] {' '});
                    int a = mydatabase.setTimeStart(cbSetupBegin.SelectedIndex);
                    int b = mydatabase.setTimeFinish(int.Parse(hour[0].ToString()));
                    if (a == 1 && b == 1)
                    {
                        MessageBox.Show("Saved succeessful! ", "Informations");
                    }
                }
            }
            catch { }
        }

        private void btSetupCancel_Click(object sender, System.EventArgs e)
        {
            try
            {
                Database mydatabase = new Database();
                cbSetupBegin.SelectedIndex = mydatabase.getTimeStart();
                cbSetupFinish.Text = mydatabase.getTimeFinish().ToString() + " h";
            }
            catch { }
        }

    }
}
