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
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.IO.Ports;
using System.Threading;
using System.Text.RegularExpressions;
using System.Windows.Forms;
namespace Emboard
{
    class COM:ShowData
    {
        /// <summary>
        /// Khai bao cong COM cho truyen nhan du lieu tu Router Emboard
        /// </summary>
        public SerialPort COMPort = new SerialPort();

        /// <summary>
        /// Cong COM truyen nhan du lieu xuong module SMS
        /// </summary>
        public SerialPort COMSMS = new SerialPort();

        /// <summary>
        /// Thread doc du lieu tu cong COM
        /// </summary>
        public Thread comPort = null;
        public Thread thread_comSMS = null;

        /// <summary>
        /// Du lieu nhan ve tu module SMS qua cong COM
        /// </summary>
        private static string dataReadCOMSMS = null;
        public static string DataReadCOMSMS
        {
            set { dataReadCOMSMS = value; }
            get { return dataReadCOMSMS; }
        }

        /// <summary>
        /// Du lieu doc ve tu Router Emboard thong qua COM
        /// </summary>
        private string dataReadCOM = null;
        public string DataReadCOM
        {
            set { dataReadCOM = value; }
            get { return dataReadCOM; }
        }

        /// <summary>
        /// Loi tra ve trong bat loi
        /// </summary>
        protected string ERR; 

        /// <summary>
        /// Ham khoi tao cong COM truyen nhan xuong router emboard
        /// </summary>
        /// <param name="port"></param>
        /// <param name="baud"></param>
        public COM()
        {
            COMPort.PortName = "COM2";
            COMPort.BaudRate = 19200;
            COMPort.StopBits = StopBits.One;
            COMPort.Parity = Parity.None;
            COMPort.DataBits = 8;
            COMPort.ReceivedBytesThreshold = 1;
        }

        public void ThreadComPort()
        {
            comPort = new Thread(new ThreadStart(openComPort));
            comPort.Start();
        }
        public void ThreadCOMSMS()
        {
            thread_comSMS= new Thread(new ThreadStart(openCOMSMS));
            thread_comSMS.Start();
        }
        /// <summary>
        /// Ham nhan du lieu tu cong COM
        /// Du lieu gui tu cac : sensor, actor
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public virtual void comPort_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {}

        /// <summary>
        /// Ham mo cong COM
        /// </summary>
        /// <returns></returns>
        public void openComPort()
        {
            try
            {
                if (COMPort.IsOpen == false)
                {
                    COMPort.Open();
                    DisplayData("(" + showTime() + ")Da mo cong COM", txtShowData);
                }
                //COMPort.DataReceived += new SerialDataReceivedEventHandler(comSMS_DataReceived);
                COMPort.DataReceived += new SerialDataReceivedEventHandler(comPort_DataReceived);
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                DisplayData("Dang ket noi.......", txtShowData);
            }
        }
        public void openCOMSMS() {
            
           COMSMSInit();
           // MessageBox.Show("start");
            try
            {
               // MessageBox.Show("VAO sau cominit");
                if (COMSMS.IsOpen == false)
                {
                    COMSMS.Open();
                   // MessageBox.Show("VAO sau khi cong da mo");
                    DisplayData("(" + showTime() + ")Da mo cong COMSMS", txtShowData);
                }
                //COMPort.DataReceived += new SerialDataReceivedEventHandler(comSMS_DataReceived);
                COMSMS.DataReceived += new SerialDataReceivedEventHandler(port_DataReceived);
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                MessageBox.Show("loi");
                DisplayData("Dang ket noi.......", txtShowData);
            }
           // MessageBox.Show("SAu try catch");
            
        }

        /// <summary>
        /// Ham dong cong COM
        /// </summary>
        /// <returns></returns>
        public int closeCOM()
        {
            try
            {
                if (COMPort.IsOpen == true)
                { COMPort.DiscardInBuffer(); COMPort.Close(); }
                DisplayData("(" + showTime() + ")Da dong cong COM", txtShowData);
                return 1;
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                return -1;
            }
        }

        /// <summary>
        /// Ham gui du lieu xuong cong COM
        /// Gui lenh qua cong COM xuong Router Emboard
        /// </summary>
        /// <param name="com"></param>
        /// <returns></returns>
        public int writeByteData(byte[] com)
        {
            try
            {
                if (COMPort.IsOpen == true)
                {
                    COMPort.Write(com, 0, com.Length);
                }
                return 1;
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                return -1;
            }
        }

        /// <summary>
        /// Cac ham phuc vu truyen nhan du lieu qua cong COM module SMS
        /// </summary>
        /// 
        public string[] messageL;
        public string strm;
        public void COMSMSInit()
        {
            //try
            {
                //receiveNow = new AutoResetEvent(false);//new
                COMSMS.PortName = "COM4";
                COMSMS.BaudRate = 115200;
                COMSMS.Parity = Parity.None;
                COMSMS.StopBits = StopBits.One;
                COMSMS.DataBits = 8;
                COMSMS.ReceivedBytesThreshold = 1;
              //  COMSMS.ReadTimeout = 300;             //300new
                //COMSMS.WriteTimeout = 300;           //300new
                //COMSMS.Encoding = Encoding.GetEncoding("iso-8859-1");//new
                COMSMS.Open();
                String[] strport = SerialPort.GetPortNames();
                String x = "a";
                String portopen = "";
                if (COMSMS.IsOpen)
                {
                    //x = ExecCommand(COMSMS, "AT+CMGS=" + "01675211874" + "\r\n",300,"loi me roi");
                    for (int i = 0; i < strport.Length; i++) { portopen = portopen + strport[i]; }
                    MessageBox.Show(portopen);
                   // COMSMS.Write("AT+CMGF=1\r");
//Thread.Sleep(1000);
                 //   COMSMS.Write("AT+CMGS=" + "0987043079" + "\r\n");
                  //  Thread.Sleep(1000);
                  //  COMSMS.Write("ok");
                    

                }
              //  COMSMS.DataReceived += new SerialDataReceivedEventHandler(port_DataReceived);
               /* ShortMessageCollection objShortMessageCollection = this.ReadSMS(COMSMS);
                //string[] strmsg;
                foreach (ShortMessage msg in objShortMessageCollection)
                {

                    messageL = new string[] { msg.Index, msg.Sent, msg.Sender, msg.Message };
                    strm = strm + messageL[0] + messageL[1] + messageL[2] + messageL[3] + "\n";
                }
                MessageBox.Show("SMS " + strm);*/
              //  COMSMS.DtrEnable = true;//new
               // COMSMS.RtsEnable = true;//new
            }
            //catch (Exception ex) {
              //  MessageBox.Show("Loi o day");
            //}
        }

        
        /// <summary>
        /// Nhan du lieu tu module GSM qu cong COM
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public virtual void comSMS_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            try
            { 
                if (COMSMS.IsOpen == false)
                    COMSMS.Open();
                if (e.EventType == SerialData.Chars)
                {
                    //receiveNow.Set();
                }
            }
            catch (Exception ex)
            {
                throw ex;
            }
           /* try
            {
                if (COMSMS.IsOpen == true)
                {
                    //dataReadCOMSMS = this.ReadSMS(COMSMS);
                    //dataReadCOM = COMSMS.ReadLine();
                    String x = "";
                    //x = COMSMS.ReadLine();
                   // dataReadCOMSMS = COMSMS.ReadExisting();
                    MessageBox.Show("ggggg");
                }
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }*/
        }
        public void port_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            MessageBox.Show("sms1");
            try
            {
                if (e.EventType == SerialData.Chars)
                {
                    //MessageBox.Show();
                    receiveNow.Set();
                    MessageBox.Show("sms");
                }
            }
            catch (Exception ex)
            {
               MessageBox.Show("error"+ex.ToString());
            }
        }
        public string ReadResponse(SerialPort port, int timeout)
        {
            string buffer = string.Empty;
            try
            {
                do
                {
                    if (receiveNow.WaitOne(timeout, false))
                    {
                        string t = port.ReadExisting();
                        buffer += t;
                    }
                    else
                    {
                        if (buffer.Length > 0)
                            throw new ApplicationException("Response received is incomplete.");
                        else
                            throw new ApplicationException("No data received from phone.");
                    }
                }
                while (!buffer.EndsWith("\r\nOK\r\n") && !buffer.EndsWith("\r\n> ") && !buffer.EndsWith("\r\nERROR\r\n"));
            }
            catch (Exception ex)
            {
                throw ex;
            }
            return buffer;
        }
        //Execute AT Command
        public AutoResetEvent receiveNow;
        public string ExecCommand(SerialPort port, string command, int responseTimeout, string errorMessage)
        {
            try
            {

                port.DiscardOutBuffer();
                port.DiscardInBuffer();
                receiveNow.Reset();
                port.Write(command + "\r");

                string input = ReadResponse(port, responseTimeout);
                if ((input.Length == 0) || ((!input.EndsWith("\r\n> ")) && (!input.EndsWith("\r\nOK\r\n"))))
                    throw new ApplicationException("No success message was received.");
                return input;
            }
            catch (Exception ex)
            {
                throw ex;
            }
        }
        #region Count SMS
        public int CountSMSmessages(SerialPort port)
        {
            int CountTotalMessages = 0;
            try
            {

                #region Execute Command

                string recievedData = ExecCommand(port, "AT", 300, "No phone connected at ");
                recievedData = ExecCommand(port, "AT+CMGF=1", 300, "Failed to set message format.");
                String command = "AT+CPMS?";
                recievedData = ExecCommand(port, command, 1000, "Failed to count SMS message");
                int uReceivedDataLength = recievedData.Length;

                #endregion

                #region If command is executed successfully
                if ((recievedData.Length >= 45) && (recievedData.StartsWith("AT+CPMS?")))
                {

                    #region Parsing SMS
                    string[] strSplit = recievedData.Split(',');
                    string strMessageStorageArea1 = strSplit[0];     //SM
                    string strMessageExist1 = strSplit[1];           //Msgs exist in SM
                    #endregion

                    #region Count Total Number of SMS In SIM
                    CountTotalMessages = Convert.ToInt32(strMessageExist1);
                    #endregion

                }
                #endregion

                #region If command is not executed successfully
               /* else if (recievedData.Contains("ERROR"))
                {

                    #region Error in Counting total number of SMS
                    string recievedError = recievedData;
                    recievedError = recievedError.Trim();
                    recievedData = "Following error occured while counting the message" + recievedError;
                    #endregion

                }*/
                #endregion

                return CountTotalMessages;

            }
            catch (Exception ex)
            {
                throw ex;
            }

        }
        #endregion
        public ShortMessageCollection ReadSMS(SerialPort port)
        {
            // Set up the phone and read the messages
            ShortMessageCollection messages = null;
            try
            {
                #region Execute Command
                // Check connection
                ExecCommand(port, "AT", 300, "No phone connected");
                // Use message format "Text mode"
                ExecCommand(port, "AT+CMGF=1", 300, "Failed to set message format.");
                // Use character set "PCCP437"
                ExecCommand(port, "AT+CSCS=\"PCCP437\"", 300,
                "Failed to set character set.");
                // Select SIM storage
                ExecCommand(port, "AT+CPMS=\"SM\"", 300,"Failed to select message storage.");
                // Read the messages
                string input = ExecCommand(port, "AT+CMGL=\"ALL\"", 5000,
                    "Failed to read the messages.");
                #endregion

                #region Parse messages
                messages = ParseMessages(input);
                #endregion
            }
            catch (Exception ex)
            {
                throw new Exception(ex.Message);
            }

            if (messages != null)
                return messages;
            else
                return null;
        }
        public ShortMessageCollection ParseMessages(string input)
        {
            ShortMessageCollection messages = new ShortMessageCollection();
            
            try
            {
                Regex r = new Regex(@"\+CMGL: (\d+),""(.+)"",""(.+)"",(.*),""(.+)""\r\n(.+)\r\n");
                Match m = r.Match(input);
                while (m.Success)
                {
                    ShortMessage msg = new ShortMessage();

                    //msg.Index = int.Parse(m.Groups[1].Value);
                    msg.Index = m.Groups[1].Value;
                    msg.Status = m.Groups[2].Value;
                    msg.Sender = m.Groups[3].Value;
                    msg.Alphabet = m.Groups[4].Value;
                    msg.Sent = m.Groups[5].Value;
                    msg.Message = m.Groups[6].Value;

                    messages.Add(msg);
                    
                    m = m.NextMatch();
                }

            }
            catch (Exception ex)
            {
                throw ex;
            }
            return messages;
        }
         public bool DeleteMsg(SerialPort port , string p_strCommand)
        {
            bool isDeleted = false;
            try
            {

                #region Execute Command
                string recievedData = ExecCommand(port,"AT", 300, "No phone connected");
                recievedData = ExecCommand(port,"AT+CMGF=1", 300, "Failed to set message format.");
                String command = p_strCommand;
                recievedData = ExecCommand(port,command, 300, "Failed to delete message");
                #endregion

                if (recievedData.EndsWith("\r\nOK\r\n"))
                {
                    isDeleted = true;
                }
                /*
                if (recievedData.Contains("ERROR"))
                {
                    isDeleted = false;
                }*/
               
                return isDeleted;
            }
            catch (Exception ex)
            {
                throw ex; 
            }
            
        }  
        

    
        /// <summary>
        /// Chuyen doi string sang mang byte
        /// </summary>
        /// <param name="com"></param>
        /// <returns></returns>
        public byte[] ConvertTobyte(string com)
        {
            byte[] command = new byte[4];
            string nn1 = com.Substring(0, 2);
            string nn2 = com.Substring(2, 2);
            string ss = com.Substring(4, 2);
            int kytu = Convert.ToInt16(com[7]);
            int byte0 = int.Parse(nn1, System.Globalization.NumberStyles.HexNumber);
            int byte1 = int.Parse(nn2, System.Globalization.NumberStyles.HexNumber);
            int byte3 = int.Parse(ss, System.Globalization.NumberStyles.Integer);
            int kq = 0;
            if (com[6] == '0')
            {
                kq = byte3;
            }
            if (com[6] == '1')
            {
                kq = byte3 + 128;
            }
            command[0] = (byte)byte0;
            command[1] = (byte)byte1;
            command[2] = (byte)kq;
            command[3] = (byte)kytu;
            return command;
        }

        /// <summary>
        /// Dong cong COM gui tin nhan
        /// </summary>
        public void closeCOMSMS()
        {
            try
            {
                if (COMSMS.IsOpen == true)
                    COMSMS.Close();
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }
    }
}
