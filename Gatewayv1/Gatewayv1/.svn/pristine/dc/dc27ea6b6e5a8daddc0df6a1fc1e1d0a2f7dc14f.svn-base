using System;
using System.Windows.Forms;
using System.Drawing;
using System.Xml;

namespace Emboard
{
    public partial class Emboard : Form
    {
        private Graphics _bgGraphical, _iconGraphical;
        Bitmap _bgBitmap = new Bitmap(465, 214);
        private Bitmap _mapBitmap, _iconBitmap, _inviBitmap;
        Database myDatabase=new Database();
        private void Emboard_Load(object sender, EventArgs e)
        {
            Loadmap();
            Drawmap();
            pictureBox1.Image = _bgBitmap;
        }
        public void Loadmap()
        {
            //_mapBitmap = new Bitmap(@"\Storage Card\hoc54\hoc\Imagemap\mapcp1.png");
            //_iconBitmap = new Bitmap(@"\Storage Card\hoc54\hoc\Imagemap\blue.png");
            _mapBitmap = new Bitmap(@"F:\Gatewayv1\Image\mapcp1.png");
            _iconBitmap = new Bitmap(@"F:\Gatewayv1\Image\red.png");
            _inviBitmap = new Bitmap(@"F:\Gatewayv1\Image\grey.png");
        }

        private void pictureBox1_MouseDown(object sender, MouseEventArgs e)
        {
            if (e.Button==MouseButtons.Right)
            {
                MouseDown(e.X, e.Y);    
            }
            
        }

        private void menuGetInformation_Click(object sender, EventArgs e)
        {
            string test = "0000000$";
            byte[] testcm = convert.ConvertTobyte(test);
            comPort.WriteData(testcm);
            tbShow.Text += "\r\n Lenh tabmap";
        }

        public void MouseDown(int mousex,int mousey)
        {
            bool t1 = (mousex < 250) & (mousex > 210);
            bool t2 = (mousey < 75) & (mousey > 55);
            if (t1&t2)
            {
                //MessageBox.Show(mousex.ToString()+" fgdfghd "+mousey.ToString());
                //Point p = (sender as Control).PointToScreen(e.Location);
                //contextMenu2.Show(Control.MousePosition, Point.Empty);
                contextMenu2.Show(this,PointToClient(MousePosition));
            }
            else
            {
                //MessageBox.Show(mousex.ToString() + "  " + mousey.ToString());
                contextMenu1.Show(this,PointToClient(MousePosition));
                //string test = myDatabase.StatusSensor(2);
                //MessageBox.Show(test);
            }
        }

        public void Drawmap()
        {
            _bgGraphical = Graphics.FromImage(_bgBitmap);
            _iconGraphical = Graphics.FromImage(_bgBitmap);
            _bgGraphical.DrawImage(_mapBitmap, 0, 0);
            for (int i = 0; i <myDatabase.getTotalSensor() ; i++)
            {
                //MessageBox.Show(i.ToString());
                string status = myDatabase.StatusSensor(i);
                switch (status)
                {
                    case "True":
                        _iconGraphical.DrawImage(_iconBitmap, myDatabase.GetX(i), myDatabase.GetY(i));
                        //MessageBox.Show("True");
                        break;
                    case "False":
                        _iconGraphical.DrawImage(_inviBitmap, myDatabase.GetX(i), myDatabase.GetY(i));
                        //MessageBox.Show("asdfa");
                        break;
                }
            }
        }
    }
}
