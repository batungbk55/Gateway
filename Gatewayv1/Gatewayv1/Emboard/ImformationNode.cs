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
    class ImformationNode
    {
        /// <summary>
        /// Dia chi mac cua cac node (sensor va actor)
        /// </summary>
        private static string mac = null;
        public string Mac
        {
            get { return mac; }
            set { mac = value; }
        }

        /// <summary>
        /// Dia chi IP cua cac node(sensor va actor)
        /// </summary>
        private static string ip = null;
        public string Ip
        {
            get { return ip; }
            set { ip = value; }
        }

        /// <summary>
        /// Ma lenh cua cac node 
        /// </summary>
        private string command = null;
        public string Command
        {
            get { return command; }
            set { command = value; }
        }

        /// <summary>
        /// Ma lenh khi chuyen thanh mang byte cac node
        /// </summary>
        private byte[] commandbyte = null;
        public byte[] CommandByte {
            get { return commandbyte; }
            set { commandbyte = value; }
        }

        /// <summary>
        /// tinh thoi gian tre dap ung su kien
        /// </summary>
        public static Hashtable timeDapUng = new Hashtable();
    }
}
