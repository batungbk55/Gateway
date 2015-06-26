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
using System.Collections.Generic;
using System.Text;
using System.IO.Ports;
using System.Windows.Forms;
using System.Threading;
using System.Collections;
namespace Emboard
{
    class Process : COM
    {
        static int idTimeSendCanhBao = 0;
        private static int time_alarm = 0;
        public int Time_alarm
        {
            set { time_alarm = value; }
            get { return time_alarm; }
        }
        static int id_van_bat = 0;
        public Thread threadProcess = null;
        private Queue DataProcess = new Queue();
        /// <summary>
        ///Tao timer
        /// </summary>
        public System.Windows.Forms.Timer timer = new System.Windows.Forms.Timer();

        /// <summary>
        /// Tao doi tuong sensor
        /// </summary>
        private Sensor sensor = new Sensor();

        /// <summary>
        /// Tao doi tuong actor
        /// </summary>
        private Actor actor = new Actor();

        /// <summary>
        /// Tao doi tuong ConvertData
        /// </summary>
        private ConvertData Data = new ConvertData();

        /// <summary>
        /// Tao doi tuong quan ly van
        /// </summary>
        private Van van = new Van();

        /// <summary>
        /// Tao doi tuong quan ly web server
        /// </summary>
        private WebServer web = new WebServer();

        /// <summary>
        /// Tao doi tuong ve ban do
        /// </summary>
        private libDraw drawImage = new libDraw();

        /// <summary>
        /// Tao doi tuong co so du lieu
        /// </summary>
        private Database db;

        /// <summary>
        /// Thuoc tinh ve ban do
        /// </summary>
        public PictureBox pic;

        /// <summary>
        /// Thoi gian tu dong tat bom, lay tu co so du lieu
        /// </summary>
        private static int time_control = 0;
        public int Time_control
        {
            set { time_control = value; }
            get { return time_control; }
    }

        /// <summary>
        /// Ham khoi tao 
        /// Goi phuong thuc khoi tao cua lop cha
        /// </summary>
        /// <param name="name"></param>
        /// <param name="baud"></param>
        public Process() : base()
        {}

        /// <summary>
       /// Override lai ham nhan du lieu tu router emboard qua cong COM
       /// </summary>
       /// <param name="sender"></param>
       /// <param name="e"></param>
        public override void comPort_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            try
            {
                if (COMPort.IsOpen == true)
                {
                    DataReadCOM = COMPort.ReadLine();
                    //DataReadCOM = COMPort.ReadExisting();
                    //MessageBox.Show("COM1 mở");
                    if (DataReadCOM[0] != '#' && DataReadCOM[0] != 'R')   // sai o cho nay, can hoi lai 
                    {
                        DisplayData(DataReadCOM, txtShowData);
                    }
                    if ((DataReadCOM.Length >= 6) && (DataReadCOM[0] == '#'))
                    {
                        WebServer.dataSendToWeb.Enqueue(DataReadCOM);
                        //convertData(DataReadCOM);
                        DataProcess.Enqueue(DataReadCOM);
                    }
                }
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }
       /* public override void comSMS_DataReceived(object sender, SerialDataReceivedEventArgs e)
        { 
             try
            {
                if (COMSMS.IsOpen == true)
                {
                    DataReadCOMSMS = this.ReadSMS(COMSMS).ToString();
                    MessageBox.Show("DOC TIN NHAN");
                   // DataReadCOMSMS = COMSMS.ReadLine();
                    DataProcess.Enqueue(DataReadCOMSMS);
                    //dataReadCOM = COMSMS.ReadLine();
                    //dataReadCOMSMS = COMSMS.ReadExisting();
                }
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }*/
        public void processData()
        {
            try
            {
                while (true)
                {
                    if (DataProcess.Count > 0)
                    {
                        convertData(DataProcess.Dequeue().ToString());
                    }
                    Thread.Sleep(100);
                }
            }
            catch { }
        }
        public Thread threadSMS = null;
        
        public void ThreadProcessData()
        {
            threadProcess = new Thread(new ThreadStart(processData));
            threadProcess.IsBackground = true;
            threadProcess.Start();
        }
        /// <summary>
        /// Ham boc tach du lieu tu cong COM
        /// Dinh dang ban tin tra ve:
        /// #JN:NNNN MM  Ban tin join mang
        /// #AD:NNNN MM D1D2D3D4 D5D6D7D8 E1E2E3E4 Ban tin du lieu dinh ky
        /// #RD:NNNN MM D1D2D3D4 D5D6D7D8 E1E2E3E4 Ban tin du lieu theo yeu cau
        /// #VL:MM Ban tin thong bao ngu cua mot sensor
        /// #OK:NNNN MM SS Ban tin thong bao trang thai actor
        /// #SN: NNNN MM SS  Ban tin thong bao trang thai sensor
        /// </summary>
        /// <param name="data"></param>
        public void convertData(string data)
        {
            try
            {
                switch (data[1])
                {
                    case 'M': MessageBox.Show(data); break;
                    case 'J':
                        Data.convertDataJoinNetwork(data);
                        if (Data.checkSensor == false)
                        {
                            DisplayData("(" +showTime()+ "): Thong tin trang thai Actor: \r\n Actor " + actor.Ip + " (" + actor.Mac + ") " + " : \r\n Van hoat dong trong mang !!!\r\n", txtShowData);
                        }
                        else
                        {
                            DisplayData("(" + showTime() + "): Thong tin gia nhap mang: \r\n Sensor " + sensor.Ip + " (" + sensor.Mac + ") " + " : \r\n Da gia nhap vao mang !!!\r\n", txtShowData);
                        }
                        drawImage.reload(pic);
                         break;
                    case 'A':
                         db = new Database();
                         Data.convertDataSensor(data);
                         DisplayData("(" + showTime() + "): Du lieu dinh ky :\r\n Sensor " + sensor.Ip + "(" + sensor.Mac + "): \r\n     Nhiet do: " + sensor.Temperature + "\r\n     Do am: " + sensor.Humidity + "\r\n     Nang luong : " + sensor.Energy + "\r\n", txtShowData);
                         sensor.saveDataSensor(sensor.Mac, sensor.Ip, sensor.Temperature, sensor.Humidity, sensor.Energy);
                         if(sensor.Mac[0] == '0')
                         {
                            int time_now_batvan = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second;
                            string _van = db.getVanSensor(sensor.Mac);
                            int id = int.Parse(_van.Substring(1, 1));
                            //int id_van_bat = 0;
                            if (sensor.Temperature > db.getTempVan(id) && sensor.Humidity < db.getHumiVan(id))
                            {
                                if (DateTime.Now.Hour >= db.getTimeStart() && DateTime.Now.Hour < db.getTimeFinish())
                                {
                                    if (id == 1)
                                    {
                                        int time_van_sau = db.getTimeVan(2);
                                        int time_van = db.getTimeVan(1);
                                        int van_bat = van.selectVanOn(id, time_van,time_van_sau);
                                        DisplayData("Thoi gian bat van 1 la: " + van.getTimeFormat(time_van), txtShowData);
                                        DisplayData("Thoi gian bat van 2 la: " + van.getTimeFormat(time_van_sau), txtShowData);
                                        DisplayData("Quyet dinh bat van: " + van_bat, txtShowData);
                                        DisplayData("Gui lenh bat van " + van_bat + " tu dong!", txtShowData);
                                        id_van_bat = van_bat;
                                        string command = actor.commandOnActor(van_bat, "0000");
                                        byte[] byteCommand = ConvertTobyte(command);
                                        writeByteData(byteCommand);
                                    }
                                    else if(id == 5){
                                        int time_van_truoc = db.getTimeVan(4);
                                        int time_van = db.getTimeVan(5);
                                        int van_bat = van.selectVanOn(id, time_van, time_van_truoc);
                                        DisplayData("Thoi gian bat van 5 la: " + van.getTimeFormat(time_van), txtShowData);
                                        DisplayData("Thoi gian bat van 4 la: " + van.getTimeFormat(time_van_truoc), txtShowData);
                                        DisplayData("Quyet dinh bat van: " + van_bat, txtShowData);
                                        DisplayData("Gui lenh bat van " + van_bat + " tu dong!", txtShowData);
                                        id_van_bat = van_bat;
                                        string command = actor.commandOnActor(van_bat, "0000");
                                        byte[] byteCommand = ConvertTobyte(command);
                                        writeByteData(byteCommand);
                                    }
                                    else if (id == 6)
                                    {
                                        DisplayData("Gui lenh bat van 6 tu dong!", txtShowData);
                                        id_van_bat = 6;
                                        string command = actor.commandOnActor(6, "0000");
                                        byte[] byteCommand = ConvertTobyte(command);
                                        writeByteData(byteCommand);
                                    }
                                    else
                                    {
                                        int van_truoc = id - 1;
                                        int van_sau = id + 1;
                                        int time_van = db.getTimeVan(id);
                                        int time_van_truoc = db.getTimeVan(van_truoc);
                                        int time_van_sau = db.getTimeVan(van_sau);
                                        int van_bat = van.selectVanOn(id, time_van, time_van_truoc,time_van_sau);
                                        DisplayData("Thoi gian bat van " + id + " la: " + van.getTimeFormat(time_van), txtShowData);
                                        DisplayData("Thoi gian bat van " + van_truoc + " la: " + van.getTimeFormat(time_van_truoc), txtShowData);
                                        DisplayData("Thoi gian bat van " + van_sau + " la: " + van.getTimeFormat(time_van_sau), txtShowData);
                                        DisplayData("Quyet dinh bat van: " + van_bat, txtShowData);
                                        DisplayData("Gui lenh bat van " + van_bat + " tu dong!", txtShowData);
                                        id_van_bat = van_bat;
                                        string command = actor.commandOnActor(van_bat, "0000");
                                        byte[] byteCommand = ConvertTobyte(command);
                                        writeByteData(byteCommand);
                                    }
                                    Van.statusVan[id_van_bat] = true;
                                    Van.countTimeOnVan[id_van_bat] = 0;
                                    ImformationNode.timeDapUng.Remove(id_van_bat);
                                    ImformationNode.timeDapUng.Add(id_van_bat,time_now_batvan);
                                }
                                else
                                {
                                    DisplayData("Khong phai khoang thoi gian bat bom (" + db.getTimeStart() + " h - " + db.getTimeFinish() + " h)", txtShowData);
                                }
                            }
                         }
                         drawImage.reload(pic);
                        break;
                    case 'R':
                        Data.convertDataSensor(data);
                        DisplayData("(" + showTime() + "): Du lieu theo yeu cau :\r\n Sensor " + sensor.Ip + "(" + sensor.Mac + "): \r\n     Nhiet do: " + sensor.Temperature + "\r\n     Do am: " + sensor.Humidity + "\r\n     Nang luong : " + sensor.Energy , txtShowData);
                        try
                        {
                            int time = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second - (int)ImformationNode.timeDapUng[sensor.Mac];
                            ImformationNode.timeDapUng.Remove(sensor.Mac);
                            DisplayData("Thoi gian dap ung lay du lieu: " + time + " giay\r\n", txtShowData);
                            if (time < 60)
                            {
#if ACTOR_BAOCHAY
                                string timeSendToWeb = "DB" + time;
#else
                            string timeSendToWeb = "DA" + time;
#endif
                                WebServer.dataSendToWeb.Enqueue(timeSendToWeb);
                            }
                        }
                        catch { DisplayData("",txtShowData); }
                        sensor.saveDataSensor(sensor.Mac, sensor.Ip, sensor.Temperature, sensor.Humidity, sensor.Humidity);
                        break;
                    case 'S':
                        db = new Database();
                        Data.convertStateNode(data);
                        if (sensor.StateSensor == "02")
                        {
                            try
                            {
                                int time_now_canhbao = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second;
                                ImformationNode.timeDapUng.Remove("warning");
                                ImformationNode.timeDapUng.Add("warning", time_now_canhbao);
                            }
                            catch { }
                            DisplayData("(" + showTime() + "):Canh bao chay tai node " + sensor.Mac, txtShowData);
                            string phone_number = db.getPhoneNumber();
                            DisplayData("Gui tin nhan den so " + phone_number, txtShowData);
                            if (COMSMS.IsOpen == false)
                            {
                                COMSMS.Open();
                            }
                            COMSMS.Write("AT+CMGS=" + phone_number + "\r\n");
                            COMSMS.Write("Da canh bao chay o sensor co dia chi MAC " + sensor.Mac + (char)26 + (char)13);
                            //COMSMS.Write("Da canh bao chay o sensor co dia chi MAC " + sensor.Mac + (char)26 + (char)13);
                            COMSMS.DiscardInBuffer();
                            COMSMS.DiscardOutBuffer();
                            COMSMS.Close();
                        }
                        else if (sensor.StateSensor == "03")
                        {
                            DisplayData("(" + showTime() + "):Het nang luong tai node " + sensor.Mac + "\r\n", txtShowData);
                        }
                        else
                        {
                            DisplayData("(" + DateTime.Now + "): Phat hien xam nhap tai node " + sensor.Mac + "\r\n", txtShowData);
                        }
                        break;
                    case 'V':
                        Data.convertImformationSleep(data);
                        DisplayData("(" + showTime() + "): Sensor " + sensor.Mac + " da vao che do ngu\r\n", txtShowData);
                        drawImage.reload(pic);
                        break;
                    case 'O':
                        Data.convertImformationActor(data);
                        if (actor.StatusActor)
                        {
                            if (van.VanID == 15)
                            {
                                DisplayData("(" + showTime() + "): Da bat tat ca cac van", txtShowData);
                            }
                            else
                            {
#if ACTOR_BAOCHAY
                                DisplayData("(" + showTime() + "): Da bat canh bao muc " + van.VanID, txtShowData);
                                try
                                {
                                    int time_canhbao = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second - (int)ImformationNode.timeDapUng["warning"];
                                    ImformationNode.timeDapUng.Remove("warning");
                                    DisplayData("Thoi gian dap ung canh bao chay "+time_canhbao+" giay", txtShowData);
                                    if (time_canhbao < 60)
                                    {
                                        string timeSendToWeb = "F" + time_canhbao;
                                        WebServer.dataSendToWeb.Enqueue(timeSendToWeb);
                                    }
                                }
                                catch{}
#else
                                DisplayData("(" + showTime() + "): Da bat van so " + van.VanID , txtShowData);
                                //bat dau tinh thoi gian bat bơm
                                int time_on = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second;
                                string keyVan = "0" + van.VanID;
                                Van.TimeOnVan.Remove(keyVan);
                                Van.TimeOnVan.Add(keyVan, time_on);
                                try
                                {
                                    int time_dapung_tuoicay = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second - (int)ImformationNode.timeDapUng[van.VanID];
                                    ImformationNode.timeDapUng.Remove(van.VanID);
                                    DisplayData("Thoi gian dap ung tuoi cay tu dong " + time_dapung_tuoicay + " giay", txtShowData);
                                    if(time_dapung_tuoicay < 60)
                                    {
                                        string timeSendToWeb = "T" + time_dapung_tuoicay;
                                        WebServer.dataSendToWeb.Enqueue(timeSendToWeb);
                                    }
                                }
                                catch {}
#endif
                            }
                        }
                        else
                        {
                            if (van.VanID == 15)
                            {
                                DisplayData("(" + showTime() + "): Da tat tat ca cac van", txtShowData);
                            }
                            else
                            {
                                DisplayData("(" + showTime() + "): Da tat van so " + van.VanID, txtShowData);
                                try
                                {
                                    db = new Database();
                                    string keyVanOff = "0" + van.VanID;
                                    int timeOnVan = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second - (int)Van.TimeOnVan[keyVanOff];
                                    int timeOn = db.getTimeVan(van.VanID);
                                    int timeAll = timeOnVan + timeOn;
                                    db.setTimeVan(van.VanID, timeAll);
                                    string timeSendToWeb = "V" + van.VanID + timeAll;
                                    WebServer.dataSendToWeb.Enqueue(timeSendToWeb);
                                }
                                catch { }
                            }
                        }
                        try
                        {
                            int time_actor = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second - (int)ImformationNode.timeDapUng[actor.Mac];
                            ImformationNode.timeDapUng.Remove(actor.Mac);
                            DisplayData("Thoi gian dap ung dieu khien actor "+time_actor+" giay\r\n", txtShowData);
                            if (time_actor < 60)
                            {
#if ACTOR_BAOCHAY
                                string timeSendToWeb = "CB" + time_actor;
#else
                            string timeSendToWeb = "CA" + time_actor;
#endif
                                WebServer.dataSendToWeb.Enqueue(timeSendToWeb);
                            }

                        }
                        catch { DisplayData("", txtShowData); }
                        drawImage.reload(pic);
                        break;
                    case 'P':
                        Data.convertDataJoinNetwork(data);
                        DisplayData("(" + showTime() + "): Thong tin trang thai sensor: \r\n Sensor " + sensor.Ip + " (" + sensor.Mac + ") " + " : \r\n Van hoat dong trong mang !!!\r\n", txtShowData);
                        break;
                }

            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                DisplayData(ERR, txtShowData);
            }
        }
        
        /// <summary>
        /// Ham khoi tao timer
        /// </summary>
        public void TimerInit()
        {
            timer.Enabled = true;
            timer.Interval = 5000;
          //  timer.Tick += new System.EventHandler(runTimer);
        }

        /// <summary>
        /// Ham thuc hien timer
        /// </summary>
        public void runTimer(object sender, EventArgs e)
        {
            try
            {
#if ACTOR_BAOCHAY
                idTimeSendCanhBao++;
                if (idTimeSendCanhBao > Time_alarm * 12)
                {
                    int level = actor.GetLevelSendCanhBao();
                    DisplayData("Tu dong gui canh bao muc "+ level,txtShowData);
                    actor.Command = "00000" + level + "1$";
                    actor.CommandByte = ConvertTobyte(actor.Command);
                    writeByteData(actor.CommandByte);
                    idTimeSendCanhBao = 0;
                }
#endif
                for (int i = 1; i <= 6; i++)
                {
                    if (Van.statusVan[i] == true)
                    {
                        Van.countTimeOnVan[i]++;
                        if (Van.countTimeOnVan[i] > Time_control * 12)
                        {
                            DisplayData("(" + showTime() + ")Gui lenh tat van " + i + " tu dong", txtShowData);
                            string command = "00000" + i + "0$";
                            byte[] com = ConvertTobyte(command);
                            writeByteData(com);
                            Van.statusVan[i] = false;
                        }
                    }
                }
            }
            catch { }
        }

        /// <summary>
        /// Ham doc du lieu lien tuc tu web
        /// </summary>
        public void Request()
        {
            
            try
            {
              //  DisplayData("Request len web :", txtShowData);
                string[] url = connection.Confix();
                string uriCom = url[4];
                string a = null;
                while (true)
                {
                    web.DataReceiveFromWeb = web.receiveDataFromWeb(uriCom);
                   // MessageBox.Show("Dữ liệu : "+ web.DataReceiveFromWeb+" nhe");

                    if (web.DataReceiveFromWeb.Length > 0)
                    {
                        if (web.DataReceiveFromWeb[0] == '#')
                        {
                            Database myDatabase = new Database();
                            int van = int.Parse(web.DataReceiveFromWeb.Substring(1, 1));
                            float temp = float.Parse(web.DataReceiveFromWeb.Substring(2, 2));
                            float humi = float.Parse(web.DataReceiveFromWeb.Substring(4, 2));
                            myDatabase.setHumiVan(van, humi);
                            myDatabase.setTempVan(van, temp);
                            DisplayData("(" + showTime() + "): Cai dat nguong tu WEB:", txtShowData);
                            DisplayData("Van so : " + van, txtShowData);
                            DisplayData("Nhiet do : " + temp + "°C", txtShowData);
                            DisplayData("Do am : " + humi + "%", txtShowData);
                        }
                        else
                        {
                            DisplayData("(" + showTime() + "): Lenh gui tu WEB:", txtShowData);
                            string mac = web.DataReceiveFromWeb.Substring(0,2);
                            int time_web = DateTime.Now.Hour * 3600 + DateTime.Now.Minute * 60 + DateTime.Now.Second;
                            ImformationNode.timeDapUng.Remove(mac);
                           // MessageBox.Show("qua dap ung mac");
                            ImformationNode.timeDapUng.Add(mac,time_web);
                           // MessageBox.Show("qua dap ung mac 1 :" + web.DataReceiveFromWeb);
                            web.DataReceiveFromWeb = web.DataReceiveFromWeb.Substring(0,8);
                            //a = web.DataReceiveFromWeb.Substring(2, 6);
                            //web.DataReceiveFromWeb = a;
                          //  MessageBox.Show("test :" + web.DataReceiveFromWeb);
                            DisplayData("Ma lenh :" + web.DataReceiveFromWeb, txtShowData);
                            byte[] commandWeb = ConvertTobyte(web.DataReceiveFromWeb);
                            writeByteData(commandWeb);
                        }
                        web.DataReceiveFromWeb = null;
                    }
                    Thread.Sleep(500);
                }
            }
            catch(Exception ex)
            {
               // DisplayData(ex.Message.ToString()+ "Khong the lay du lieu tu WEB", txtShowData);
                
            }
        }

        /// <summary>
        /// Ham mo Thread nhan du lieu tu web
        /// </summary>
        public void ThreadReceiveFromWeb()
        {   
            web.threadReceiveFromWeb = new Thread(new ThreadStart(Request));
            web.threadReceiveFromWeb.IsBackground = true;
            web.threadReceiveFromWeb.Start();
        }
        /// <summary>
        /// Ham gui du lieu lien tuc len WEB
        /// Kiem tra hang doi du lieu can gui di 
        /// </summary>
        public void send()
        {
            try
            {
#if ACTOR_BAOCHAY
                web.sendDataToWeb("RSBC");
#else
                web.sendDataToWeb("RS");
#endif
                while (true)
                {
                    if (WebServer.dataSendToWeb.Count > 0)
                    {
                        //MessageBox.Show(dataSendToWeb.Dequeue().ToString());
                        web.sendDataToWeb(WebServer.dataSendToWeb.Dequeue().ToString());
                    }
                    Thread.Sleep(1000);
                }
            }
            catch {}
        }

        /// <summary>
        /// Mo luong gui du lieu len WEB
        /// </summary>
        public void ThreadSendToWeb()
        {
            web.threadSendToWeb = new Thread(new ThreadStart(send));
            web.threadSendToWeb.IsBackground = true;
            web.threadSendToWeb.Start();
        }
        public void clearDataCOM() {
            try {
                COMPort.DiscardInBuffer();
            }
            catch(Exception ex){}
        }
    }
}
