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
    class Sensor:ImformationNode
    {
        /// <summary>
        /// Nhiet do cua sensor
        /// </summary>
        private static float temperature;
        public float Temperature
        {
            set { temperature = value; }
            get { return temperature; }
        }

        /// <summary>
        /// Do am cua sensor
        /// </summary>
        private static float humidity;
        public float Humidity
        {
            set { humidity = value; }
            get { return humidity; }
        }

        /// <summary>
        /// Nang luong cua sensor
        /// </summary>
        private static float energy;
        public float Energy
        {
            set { energy = value; }
            get { return energy; }
        }

        /// <summary>
        /// Trang thai cua sensor
        /// </summary>
        private static string stateSensor;
        public string StateSensor
        {
            set { stateSensor = value; }
            get { return stateSensor; }
        }

        /// <summary>
        /// Tra ve loi khi bat loi
        /// </summary>
        private string ERR = null;

        /// <summary>
        /// Doi tuong ve co so du lieu
        /// </summary>
        private Database db;

        /// <summary>
        /// Tao lenh lay du lieu nhiet do, do am cac sensor
        /// </summary>
        /// <param name="ip"></param>
        /// <returns></returns>
        public string CommandSensor(string ip)
        {
            try
            {
                return ip + "000$";
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                return null;
            }
        }

        /// <summary>
        /// Lu du lieu cac sensor vao CSDL
        /// Neu dia chi mac cua sensor da ton tai thi update lai status sensor  la true
        /// Neu dia chi mac sensor khong ton tai thi tao node moi
        /// </summary>
        /// <param name="mac"></param>
        /// <param name="ip"></param>
        /// <param name="t"></param>
        /// <param name="h"></param>
        /// <param name="e"></param>
        public void saveDataSensor(string mac, string ip, float t, float h, float e)
        {
            try
            {
                db = new Database();
                string time = DateTime.Now.ToString();
                if (mac[0] == '3')
                {
                    if (db.CheckSensorBC(mac) == "true")
                    {
                        db.setNetworkIpSensorBC(mac, ip);
                        db.setStatusSensorBC(mac, true);
                    }
                    else
                    {
                        db.setSensor_bc(mac, ip, true);
                    }
                    db.SaveDataDB(t, h);
                    db.updateSensorBC(mac, ip, t, h, e, time);
                }
                else
                {
                    if (db.CheckSensor(mac) == "true")
                    {
                        db.setNetworkIpSensor(mac,ip);
                        db.setActiveSensor(mac, true);
                    }
                    else
                    {
                        db.setNodeSensor(mac, ip, true);
                    }
                    db.updateSensor(mac, ip, t, h, e, time);
                }
            }
            catch { }
        }
    }
}
