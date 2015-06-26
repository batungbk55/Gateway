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
using System.Collections.Generic;
using System.Text;
using System.Collections;
namespace Emboard
{
    class Van
    {
        /// <summary>
        /// So hieu cac van tuoi cua actor vuon lan
        /// </summary>
        private static int id;
        public int VanID
        {
            get { return id; }
            set { id = value; }
        }

        /// <summary>
        /// Thoi gian da bat cac van
        /// </summary>
        public static Hashtable TimeOnVan = new Hashtable();

        /// <summary>
        /// Trang thai hien tai cac van (on or off)
        /// </summary>
        public static bool[] statusVan = new bool[10];
        public static int[] countTimeOnVan = new int[10];
        /// <summary>
        /// Ham khoi tao 1 tham so truyen vao la so hieu van
        /// </summary>
        /// <param name="id"></param>
        /*public Van(int id)
        {
            this.VanID = id;
        }*/

        /// <summary>
        /// Ham khoi tao khong tham so
        /// </summary>
        public Van()
        {
            this.VanID = 0;
        }

        /// <summary>
        /// Dinh dang thoi gian da bat van theo dang gio: phut : giay
        /// </summary>
        /// <param name="time"></param>
        /// <returns></returns>
        public string getTimeFormat(int time)
        {
            try
            {
                string str = null;
                if (time >= 60)
                {
                    int phut = time / 60;
                    int giay = time - phut * 60;
                    str = phut + " phut " + giay + " giay!";
                }
                else
                {
                    str = time + " giay";
                }
                return str;
            }
            catch
            { return null; }
        }

        /// <summary>
        /// Lua chon van de bat khi du lieu thoa man yeu cau bat bom
        /// So sanh thoi gian bat cua van ma sensor quy dinh voi cac van ben canh
        /// nen van nao co thoi gian da bat it nhat thi chon van do de bat
        /// Ap dung cho cac van co 2 van lan can
        /// </summary>
        /// <param name="id"></param>
        /// <param name="time"></param>
        /// <param name="time_van_truoc"></param>
        /// <param name="time_van_sau"></param>
        /// <returns></returns>
        public int selectVanOn(int id, int time, int time_van_truoc, int time_van_sau)
        {
            try
            {
                int van = 0;
                int id_truoc = id - 1;
                int id_sau = id + 1;
                if (time > time_van_truoc)
                {
                    if (time_van_truoc > time_van_sau)
                    {
                        van = id_sau;
                    }
                    else
                    {
                        van = id_truoc;
                    }
                }
                else
                {
                    if(time > time_van_sau)
                    {
                        van = id_sau;
                    }
                    else
                    {
                        van = id;
                    }
                }

                return van;
            }
            catch
            { return -1; }
        }

        /// <summary>
        /// Lua chon van de bat khi du lieu dinh ky thoa man yeu cau
        /// Ham nay ap dung cho van dau va van cuoi chi co 1 van lan can
        /// </summary>
        /// <param name="id"></param>
        /// <param name="time"></param>
        /// <param name="time_van"></param>
        /// <returns></returns>
        public int selectVanOn(int id, int time, int time_van)
        {
            try
            {
                int van = id;
                int id_Van;
                if (id == 1)
                {
                    id_Van = id + 1;
                }
                else
                {
                    id_Van = id - 1;
                }
                if (time > time_van)
                {
                    van = id_Van;
                }
                return van;
            }
            catch { return -1; }
        }


    }
}
