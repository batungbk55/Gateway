using System;
using System.Collections.Generic;
using System.Text;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
using System.Windows.Forms;

namespace Emboard
{
    public partial class Map
    {
        static string appPath = @"E:\SiGate\Code305\Emboard\bin\Debug";// Đường dẫn tới nơi để chương trình
        public string mapPath; //Dường dẫn tới nơi để map
        public int zoomLevel; // Dùng xác định mức zoom hiện tại để đọc thông tin
        //Khai báo các bitmap để lưu các biểu tượng cho sensor
        public Bitmap availbleIcon, invisibleIcon, smokeWarningIcon, fireWarningIccon, energyWarningIcon, pumpOnIcon;
        public int WIDTH = 470;//Kích thước hiển thị map
        public int HEIGHT = 218;
        static int SIZE = 256;
        public int pixelX, pixelY;//Xác định tọa độ điểm giữa màn hình
        public int mouseX, mouseY; //Xác định vị trí click chuột lên picturebox
        public Bitmap bb = new Bitmap(6 * SIZE, 3 * SIZE, PixelFormat.Format16bppRgb555);
        public Bitmap b = new Bitmap(470, 218);
        Graphics gr, grb;
        //sdfsd

        public Map()
        {
            try
            {
                mapPath = appPath + @"\OpenStreetMap I1\";
                availbleIcon = new Bitmap(appPath + @"\blue.png");
                invisibleIcon = new Bitmap(appPath + @"\grey.png");
                smokeWarningIcon = new Bitmap(appPath + @"\yellow.png");
                fireWarningIccon = new Bitmap(appPath + @"\red.png");
                energyWarningIcon = new Bitmap(appPath + @"\green.png");
                pumpOnIcon = new Bitmap(appPath + @"\violet.png");

            }
            catch
            {
                try
                {
                    appPath = @"E:\SiGate\Code305\Emboard\bin\Debug";
                    mapPath = appPath + @"\OpenStreetMap I1\";
                    availbleIcon = new Bitmap(appPath + @"\blue.png");
                    invisibleIcon = new Bitmap(appPath + @"\grey.png");
                    smokeWarningIcon = new Bitmap(appPath + @"\yellow.png");
                    fireWarningIccon = new Bitmap(appPath + @"\red.png");
                    energyWarningIcon = new Bitmap(appPath + @"\green.png");
                    pumpOnIcon = new Bitmap(appPath + @"\violet.png");
                }
                catch
                {
                    MessageBox.Show(appPath);
                }

            }
        }

        /// <Load>
        /// Trả về một bitmap toàn bản đồ
        /// 
        /// </summary>
        /// <param name="zoom_level"></param>
        /// <param name="px"></param>
        /// <param name="py"></param>

        public void Load(int zoom_level, int px, int py)
        {
            zoomLevel = zoom_level;
            pixelX = px;
            pixelY = py;
            try
            {
                ////////////////////////////////////////////////
                // ham nay tra ve mot bitmap la toan bo ban do//
                ////////////////////////////////////////////////
                int x_title = px / SIZE;
                int y_title = py / SIZE;
                gr = Graphics.FromImage(bb);
                grb = Graphics.FromImage(b);
                {
                    for (int k = 0; k < 6; k++)
                        for (int l = 0; l < 3; l++)
                        {
                            try
                            {

                                Bitmap b1 = new Bitmap(mapPath + zoom_level.ToString() + @"\" + (x_title + k - 2).ToString() + @"\" + (y_title + l - 1).ToString() + @".png");
                                gr.DrawImage(b1, k * SIZE, l * SIZE);
                                b1.Dispose();
                            }
                            catch
                            {
                                Bitmap b1 = new Bitmap(appPath + @"\4.png");
                                gr.DrawImage(b1, k * SIZE, l * SIZE);
                                b1.Dispose();
                            }
                        }
                }

                Rectangle recb = new Rectangle(px - (x_title - 2) * SIZE - WIDTH / 2, py - (y_title - 1) * SIZE - HEIGHT / 2, WIDTH, HEIGHT);    // de can hinh o chinh giua
                grb.DrawImage(bb, 0, 0, recb, GraphicsUnit.Pixel);
            }
            catch
            {
                MessageBox.Show("Load map error!!!");
            }
        }

        public void drawIcon(Bitmap icon, int px, int py)
        {
            px = Convert.ToInt32(px / (Math.Pow(2, 18 - zoomLevel)));
            py = Convert.ToInt32(py / (Math.Pow(2, 18 - zoomLevel)));
            if (((pixelX - px) < (WIDTH / 2)) || ((pixelY - py) < (HEIGHT / 2)))
            {
                grb.DrawImage(icon, WIDTH / 2 - pixelX + px - 10, HEIGHT / 2 - pixelY + py - 31);
            }
        }

        public void MouseUp(int mouse_x, int mouse_y)
        {
            int deltaX, deltaY;
            deltaX = mouse_x - mouseX;
            deltaY = mouse_y - mouseY;
            pixelX = pixelX - deltaX;
            pixelY = pixelY - deltaY;
            if (deltaX == 0 && deltaY == 0) return;
            Load(zoomLevel, pixelX, pixelY);
        }

        public void MouseDown(int mouse_x, int mouse_y)
        {
            //////////////////////////////////////////////////
            //ham nay tinh toan toa do lat,long kich chuot  //
            //////////////////////////////////////////////////
            mouseX = mouse_x;
            mouseY = mouse_y;
            //MessageBox.Show(mouse_x.ToString() + "/" + mouse_y.ToString());
        }
        public void ZoomOut()
        {
            if (zoomLevel == 1) return;
            else
            {
                //calculate zoom point
                int deltaX, deltaY;
                deltaX = WIDTH / 2 - mouseX;
                deltaY = HEIGHT / 2 - mouseY;
                int pointX, pointY;
                pointX = pixelX - deltaX;
                pointY = pixelY - deltaY;
                pixelX = pointX / 2+ (WIDTH / 2 - mouseX)/2;
                pixelY = pointY / 2+(HEIGHT / 2 - mouseY)/2;
                Load(--zoomLevel, pixelX, pixelY);
            }
        }

        public void ZoomIn()
        {
            if (zoomLevel == 18) return;
            else
            {
                //calculate zoom point de vi tri con tro khong doi
                int deltaX, deltaY;
                deltaX = WIDTH / 2 - mouseX;
                deltaY = HEIGHT / 2 - mouseY;
                int pointX, pointY;
                pointX = pixelX - deltaX;
                pointY = pixelY - deltaY;
                pixelX = pointX * 2 + (WIDTH / 2 - mouseX);
                pixelY = pointY * 2 + (HEIGHT / 2 - mouseY);
                Load(++zoomLevel, pixelX, pixelY);
            }
        }
    }
}
