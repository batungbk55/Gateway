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
    class ConvertData
    {
        /// <summary>
        /// Tao doi tuong sensor
        /// </summary>
        private Sensor sensor = new Sensor();

        /// <summary>
        /// Tao doi tuong actor
        /// </summary>
        private Actor actor = new Actor();

        /// <summary>
        /// Tao doi tuong van
        /// </summary>
        private Van van = new Van();

        /// <summary>
        /// Chuoi loi tra ve
        /// </summary>
        private string ERR = null;

        /// <summary>
        /// Tao doi tuong co so du lieu
        /// </summary>
        private Database db;

        /// <summary>
        /// Kiem tra la sensor (true) hay actor (false)
        /// </summary>
        public bool checkSensor = false;

        /// <summary>
        /// Boc tach du lieu cua ban tin gia nhap mang
        /// </summary>
        /// <param name="data"></param>
        public void convertDataJoinNetwork(string data)
        {
            try
            {
                string mac = null;
                string ip = null;
                db = new Database();
                mac = data.Substring(8, 2);
                ip = data.Substring(4, 4);
                if (mac == "00" || mac == "B1")
                {

                    checkSensor = false;
                    actor.Mac = mac;
                    actor.Ip = ip;
                    if (db.CheckActor(mac) == "true")
                    {
                        db.setNetworkIpActor(mac, ip);
                        db.setStatusActor(mac, true);
                    }
                    else
                    {
                        db.setNodeActor(mac, ip, true);
                    } 
                }
                else if (mac[0] == '3')
                {
                    checkSensor = true;
                    sensor.Mac = mac;
                    sensor.Ip = ip;
                    if (db.CheckSensorBC(mac) == "true")
                    {
                        db.setNetworkIpSensorBC(mac, ip);
                        db.setStatusSensorBC(mac, true);
                    }
                    else
                    {
                        db.setSensor_bc(mac, ip, true);
                    }
                }
                else
                {
                    checkSensor = true;
                    sensor.Mac = mac;
                    sensor.Ip = ip;
                    if (db.CheckSensor(mac) == "true")
                    {
                        db.setNetworkIpSensor(sensor.Mac, sensor.Ip);
                        db.setActiveSensor(sensor.Mac, true);
                    }
                    else
                    {
                        db.setNodeSensor(sensor.Mac, sensor.Ip, true);
                    }
                }
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }

        /// <summary>
        /// Boc tachs ban tin du lieu lay nhiet do, do am va nang luong
        /// </summary>
        /// <param name="data"></param>
        public void convertDataSensor(string data)
        {
            try
            {
                float humi = 0;
                float temp = 0;
                float ener = 0;
                sensor.Mac = data.Substring(8, 2);
                sensor.Ip = data.Substring(4, 4);
                string hexd = data.Substring(10, 4);
                int td = int.Parse(hexd, System.Globalization.NumberStyles.HexNumber);
                hexd = data.Substring(14, 4);
                int rhd = int.Parse(hexd, System.Globalization.NumberStyles.HexNumber);
                hexd = data.Substring(18, 4);
                int rpd = int.Parse(hexd, System.Globalization.NumberStyles.HexNumber);
                float rpd1 = ((float)rpd / (float)4096);
                float rh_lind;// rh_lin:  Humidity linear 
                temp = (float)(td * 0.01 - 39.6);                  				//calc. temperature from ticks to [deg Cel]	
                rh_lind = (float)(0.0367 * rhd - 0.0000015955 * rhd * rhd - 2.0468);     	//calc. humidity from ticks to [%RH]
                humi = (float)((temp - 25) * (0.01 + 0.00008 * rhd) + rh_lind);   		//calc. temperature compensated humidity [%RH]
                ener = (float)(0.78 / rpd1);                                 //calc. power of zigbee
                if (humi > 100) humi = 100;       				//cut if the value is outside of
                if (humi < 0.1) humi = 0;

                sensor.Temperature = temp;
                sensor.Humidity = humi;
                sensor.Energy = ener;
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }

        /// <summary>
        /// Boc tach thong tin phan hoi tu actor
        /// </summary>
        /// <param name="data"></param>
        public void convertImformationActor(string data)
        {
            try
            {
                db = new Database();
                actor.Mac = data.Substring(8, 2);
                van.VanID = int.Parse(data.Substring(11, 1), System.Globalization.NumberStyles.HexNumber);
                int check = int.Parse(data.Substring(10, 1));
                if (check == 8)
                {
                    actor.StatusActor = true;
                    if(van.VanID == 15)
                    {
                        db.setValOn();
                    }
                    else
                    {
                        db.setStateVal(van.VanID, "on");
                    }
                }
                else
                {
                    actor.StatusActor = false;
                    if(van.VanID == 15)
                    {
                        db.setValOff();
                    }
                    else
                    {
                        db.setStateVal(van.VanID,"off");
                    }
                }
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }

        /// <summary>
        /// Boc tach trang thai node sensor
        /// </summary>
        /// <param name="data"></param>
        public void convertStateNode(string data)
        {
            try
            {
                sensor.Mac = data.Substring(8, 2);
                sensor.StateSensor = data.Substring(10, 2);
            }
            catch (Exception ex)
            { ERR = ex.Message; }
        }


        /// <summary>
        /// Boc tach ban tin thuc ngu
        /// </summary>
        /// <param name="data"></param>
        public void convertImformationSleep(string data)
        {
            try
            {
                db = new Database();
                db.setActiveSensor(data.Substring(4, 2), false);
                sensor.Mac = data.Substring(4,2);
            }
            catch (Exception ex)
            {
                ERR = ex.ToString();
            }
        }
    }
}
