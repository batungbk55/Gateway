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

namespace Emboard
{
    class Actor:ImformationNode
    {
        /// <summary>
        /// Trang thai actor
        /// </summary>
        private static bool statusActor;
        public bool StatusActor{
            set { statusActor = value; }
            get { return statusActor; }
        }

        private string ERR;
        /// <summary>
        /// Tao lenh bat van
        /// </summary>
        /// <param name="van"></param>
        /// <param name="ip"></param>
        /// <returns></returns>
        public string commandOnActor(int van, string ip)
        {
            try
            {
                string command = null;
                if (van == 15)
                    command = ip + van.ToString() + "1$";
                else
                    command = ip + "0" + van.ToString() + "1$";
                return command;
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                return null;
            }
        }

        /// <summary>
        /// Ham tao lenh tat van
        /// </summary>
        /// <param name="van"></param>
        /// <param name="ip"></param>
        /// <returns></returns>
        public string commandOffActor(int van, string ip)
        {
            try
            {
                string command = null;
                if (van == 15)
                    command = ip + van.ToString() + "0$";
                else
                    command = ip + "0" + van.ToString() + "0$";
                return command;
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                return null;
            }
        }

        public int GetLevelSendCanhBao()
        {
            try
            {
                int lv = 0;
                Database mydatabase = new Database();
                float nhietdotb = mydatabase.SumTemp();
                float doamtb = mydatabase.SumHumi();
                float level = doamtb / (float)20 - (float)(27 - nhietdotb) / (float)10;
                mydatabase.DeleteData();
                if (level > 4)
                    lv = 4;
                if ((2.5 < level) && (level < 4))
                    lv = 3;
                if ((2 < level) && (level < 2.5))
                    lv = 2;
                if (level < 2)
                    lv = 1;
                return lv;
            }
            catch
            {
                return 0;
            }
        }
    }
}
