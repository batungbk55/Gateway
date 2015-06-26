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
using System.IO.Ports;
using System.Text;
using System.Drawing;
using System.Windows.Forms;
using System.IO;
using System.Net;
using System.Xml;
using System.Collections;
using System.Threading;
namespace Emboard
{
    class libDraw
    {
        #region Variable draw map
        public PictureBox pictureBox = new PictureBox();
        public static Bitmap bit = new Bitmap(465, 218);
        public Graphics gr = Graphics.FromImage(bit);
        private Font draw_font = new Font("Tahoma", 10, FontStyle.Regular);
        private SolidBrush draw_brush = new SolidBrush(Color.Black);
        #endregion

        #region Icon
        private string path_icon_sensor_true = "";
        private string path_icon_sensor_false = "";
        private string path_icon_actor_true = "";
        private string path_icon_actor_false = "";
        private string path_icon_val_on = "";
        private string path_icon_val_off = "";
        private string path = "";
        #endregion

        public libDraw()
        {
            try
            {
                path_icon_sensor_true = Directory.GetCurrentDirectory().ToString() + @"\red.png";
                path_icon_sensor_false = Directory.GetCurrentDirectory().ToString() + @"\violet.png";
                path_icon_actor_true = Directory.GetCurrentDirectory().ToString() + @"\green.png";
                path_icon_actor_false = Directory.GetCurrentDirectory().ToString() + @"\violet.png";
                path_icon_val_on = Directory.GetCurrentDirectory().ToString() + @"\yellow.png";
                path_icon_val_off = Directory.GetCurrentDirectory().ToString() + @"\grey.png";
                path = Directory.GetCurrentDirectory().ToString() + @"\bando.png";
            }
            catch
            {
                try
                {
                    path_icon_sensor_true = @"\Storage Card\hieu54\red.png";
                    path_icon_sensor_false = @"\Storage Card\hieu54\violet.png";
                    path_icon_actor_true = @"\Storage Card\hieu54\blue.png";
                    path_icon_actor_false = @"\Storage Card\hieu54\violet.png";
                    path_icon_val_on = @"\Storage Card\hieu54\yellow.png";
                    path_icon_val_off = @"\Storage Card\hieu54\grey.png";
                    path = @"\Storage Card\hieu54\bando.png";
                }
                catch
                {
                    MessageBox.Show("Khong load duoc hinh anh");
                }
            }
        }
        //Draw sensor
        public void DrawSensor(string mac)
        {
            try
            {
                Database myDatabase = new Database();
                Bitmap icon_true;
                Bitmap icon_false;
#if ACTOR_BAOCHAY
                int pixel_x = Convert.ToInt32(myDatabase.getSensorBCPixel_x(mac));
                int pixel_y = Convert.ToInt32(myDatabase.getSensorBCPixel_y(mac));
                string status = myDatabase.getStatusSensorBC(mac);
#else
                int pixel_x = Convert.ToInt32(myDatabase.getSensorPixel_x(mac));
                int pixel_y = Convert.ToInt32(myDatabase.getSensorPixel_y(mac));
                string status = myDatabase.getStatusSensor(mac);
#endif
                icon_true = new Bitmap(path_icon_sensor_true);
                icon_false = new Bitmap(path_icon_sensor_false);
                
                if (status == "true" || status == "True")
                {
                    gr.DrawImage(icon_true, pixel_x, pixel_y);
                }
                else
                {
                    gr.DrawImage(icon_false, pixel_x, pixel_y);
                }
                gr.DrawString(mac, draw_font, draw_brush, pixel_x, pixel_y);
            }
            catch
            { }
        }

        //Draw actor
        public void DrawActor(string mac)
        {
            try
            {
                Database myDatabase = new Database();
                Bitmap icon_true;
                Bitmap icon_false;
                int pixel_x = Convert.ToInt32(myDatabase.getActorPixel_x(mac));
                int pixel_y = Convert.ToInt32(myDatabase.getActorPixel_y(mac));
                icon_true = new Bitmap(path_icon_actor_true);
                icon_false = new Bitmap(path_icon_actor_false);
                string status = myDatabase.getStatusActor(mac);
                if (status == "true" || status == "True")
                {
                    gr.DrawImage(icon_true, pixel_x, pixel_y);
                }
                else
                {
                    gr.DrawImage(icon_false, pixel_x, pixel_y);
                }
                gr.DrawString(mac, draw_font, draw_brush, pixel_x, pixel_y);
            }
            catch
            {
            }
        }
        //Draw van
        public void DrawVan(int id)
        {
            try
            {
                Database myDatabase = new Database();
                Bitmap icon_on;
                Bitmap icon_off;
                int pixel_x = Convert.ToInt32(myDatabase.getValPixel_x(id));
                int pixel_y = Convert.ToInt32(myDatabase.getValPixel_y(id));
                icon_on = new Bitmap(path_icon_val_on);
                icon_off = new Bitmap(path_icon_val_off);
                string status = myDatabase.getStateVal(id);
                if (status == "on")
                {
                    gr.DrawImage(icon_on, pixel_x, pixel_y);
                }
                else
                {
                    gr.DrawImage(icon_off, pixel_x, pixel_y);
                }
                gr.DrawString("V" + id, draw_font, draw_brush, pixel_x, pixel_y);
            }
            catch
            { }
        }

        //Load ban do
        public void reload(PictureBox pic)
        {
            pic.Invoke(new EventHandler(delegate
            {
                try
                {
                    Database myDatabase = new Database();
                    Bitmap image = new Bitmap(path);
                    gr.DrawImage(image, 0, 0);
#if ACTOR_BAOCHAY
                    XmlNodeList node = (myDatabase.xml_bc).GetElementsByTagName("node");
#else
                    XmlNodeList node = (myDatabase.xml).GetElementsByTagName("node");
                    XmlNodeList val = (myDatabase.xml).GetElementsByTagName("val");
                    foreach (XmlNode valchild in val)
                    {
                        int id = Int32.Parse(valchild.Attributes["id"].Value);
                        DrawVan(id);
                    }
#endif

                    foreach (XmlNode nodechild in node)
                    {
                        string mac = nodechild.Attributes["mac"].Value;
                        if (mac == "00" || mac[0] == 'B')
                        {
                            DrawActor(mac);
                        }
                        else
                        {
                            DrawSensor(mac);
                        }
                    }
                    
                    pic.Image = bit;
                }
                catch
                {}
            }));
        }

    }
}
