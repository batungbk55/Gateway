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
using System.Collections.Generic;
using System.Text;

namespace Emboard
{
    class ShowData
    {
        public Panel mypanel = null;
        public TextBox txtShowData;
        private int index = 0;
        private string ERR = null;
        public int Index
        {
            set { index = value; }
            get { return index; }
        }

        public void showVanOff(int val, TextBox text)
        {
            text.Invoke(new EventHandler(delegate
            {
                if (index == 2)
                {
                    if (val == 15)
                    {
                        text.Text = "\r\nTat ca cac van duoc tat thanh cong";
                    }
                    else
                    {
                        text.Text = "\r\nVan so " + val + " da duoc tat thanh cong";
                    }
                    mypanel.Show();
                }
            }));
        }

        public void showVanOn(int val, string mac, TextBox text)
        {
            text.Invoke(new EventHandler(delegate
            {
                if (index == 2)
                {
                    if (mac == "00")
                    {
                        if (val == 15)
                        {
                            text.Text = "\r\nTat ca cac van duoc bat thanh cong";
                        }
                        else
                        {
                            text.Text = "\r\nVan so " + val + " da duoc bat thanh cong";
                        }
                    }
                    else
                    {
                        text.Text = "\r\nDa bat canh bao muc " + val;
                    }
                    mypanel.Show();
                }
            }));
        }

        public void showdata(string mac, string ip, float nhietdo, float doam, float nguon, TextBox text)
        {
            text.Invoke(new EventHandler(delegate
            {
                if (index == 2)
                {
                    text.Text = "Sensor " + ip + "(" + mac + ")\r\nNhiet do : " + nhietdo + "\r\nDo am : " + doam + "\r\nNang luong : " + nguon;
                    mypanel.Show();
                }
            }));
        }

        /// <summary>
        /// Hien thi chuoi thoi gian hien tai thao dinh dang(h:m:s t)
        /// </summary>
        /// <returns></returns>
        public string showTime()
        {
            try
            {
                return DateTime.Now.ToString("HH:mm:ss tt");
            }
            catch (Exception ex)
            {
                ERR = ex.ToString();
                return null;
            }
        }

        public void DisplayData(string msg, TextBox listBox1)
        {
            listBox1.Invoke(new EventHandler(delegate
            {
                //listBox1.Font = new Font("Tahoma", 10, FontStyle.Regular);
                //if (count > 720)
                //{
                //    listBox1.Text = string.Empty;
                //    count = 0;
                //}
                listBox1.Text += msg + "\r\n";
                listBox1.SelectionStart = listBox1.Text.Length;
                listBox1.ScrollToCaret();
            }));
        }
    }
}
