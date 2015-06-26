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
using System.Net;
using System.IO;
using System.Threading;
using System.Collections;
using System.Windows.Forms;

namespace Emboard
{
    class WebServer:ShowData
    {
        //ShowData showData = new ShowData();
        /// <summary>
        /// Hang doi du lieu gui len web
        /// </summary>
        public static Queue dataSendToWeb = new Queue();

        /// <summary>
        /// Du lieu nhan tu WEB
        /// </summary>
        private static string dataReceiveFromWeb = null;
        public string DataReceiveFromWeb
        {
            set { dataReceiveFromWeb = value; }
            get { return dataReceiveFromWeb; }
        }

        /// <summary>
        /// Thread gui du lieu len web server
        /// </summary>
        public Thread threadSendToWeb = null;

        /// <summary>
        /// Thread nhan du lieu tu web server
        /// </summary>
        public Thread threadReceiveFromWeb = null;

        /// <summary>
        /// Ham gui du lieu len WEB
        /// Phuong thuc gui: GET
        /// </summary>
        /// <param name="datasend"></param>
        public void sendDataToWeb(string datasend)
        {
            try
            {
                string[] url1 = connection.Confix();
                string url = url1[2];
                if (datasend[0] == '#')
                    datasend = datasend.Substring(1, datasend.Length - 1);

                url = url + "?data=" + datasend;

                // Create web request

                HttpWebRequest request = (HttpWebRequest)WebRequest.Create(url);

                // Set value for request headers

                request.Method = "GET";

                request.ProtocolVersion = HttpVersion.Version11;

                request.AllowAutoRedirect = false;

                request.Accept = "*/*";

                request.UserAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)";

                request.Headers.Add("Accept-Language", "en-us");

                request.KeepAlive = true;

                StreamReader responseStream = null;

                HttpWebResponse webResponse = null;

                string webResponseStream = string.Empty;

                // Get response for http web request

                webResponse = (HttpWebResponse)request.GetResponse();

                responseStream = new StreamReader(webResponse.GetResponseStream());


                // Read web response into string

                webResponseStream = responseStream.ReadToEnd();

                //close webresponse
                webResponse.Close();
                responseStream.Close();
                // show data receive
                DisplayData(webResponseStream, txtShowData);
            }
            catch
            
            {
               // MessageBox.Show("Giông dở rồi , có đéo mạng đâu mà đòi chạy , ngu lắm mày bật mạng lên");
             //   DisplayData("Giông dở rồi,ngu lắm mày bật mạng lên", txtShowData);
            }
        }

        /// <summary>
        /// Ham nhan du lieu tu WEB server
        /// Phuong thuc nhan: GET
        /// </summary>
        /// <param name="url"></param>
        /// <returns></returns>
        public string receiveDataFromWeb(string url)
        {
            try
            {
                HttpWebRequest request = (HttpWebRequest)WebRequest.Create(url);

                // Set value for request headers

                request.Method = "GET";

                request.ProtocolVersion = HttpVersion.Version11;

                request.AllowAutoRedirect = false;

                request.Accept = "*/*";

                request.UserAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)";

                request.Headers.Add("Accept-Language", "en-us");

                request.KeepAlive = true;

                StreamReader responseStream = null;

                HttpWebResponse webResponse = null;

                string webResponseStream = string.Empty;

                // Get response for http web request

                webResponse = (HttpWebResponse)request.GetResponse();

                responseStream = new StreamReader(webResponse.GetResponseStream());

                // Read web response into string

                webResponseStream = responseStream.ReadToEnd();

                //close WebResponse
                webResponse.Close();

                return webResponseStream;
            }
            catch
            {
               // MessageBox.Show("khong doc duoc gi tu web");
                return "";
            }
        }
    }
}
