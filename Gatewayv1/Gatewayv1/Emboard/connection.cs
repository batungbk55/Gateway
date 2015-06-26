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
using System.IO;

namespace Emboard
{
    class connection
    {
        private static string[] confix;
        private static string path;
        public static string[] Confix()
        {
            string result = "";
            try
            {
                path = Directory.GetCurrentDirectory().ToString() + @"\config.txt";
            }
            catch
            {
                path = @"\Storage Card\Tung55\config.txt";
            }
            using (FileStream filestream = new FileStream(path, FileMode.Open))
            {
                using (StreamReader sr = new StreamReader(filestream))
                {
                    while (sr.Peek() >= 0)
                    {
                        result = sr.ReadToEnd();
                    }
                }
            }
            confix = result.Split(new Char[] { ';' });
            return confix;
        }
    }
}
