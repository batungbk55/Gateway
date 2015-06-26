@echo on
cd C:\Program Files (x86)\VideoLAN\VLC
vlc.exe -vvv "rtsp://192.168.11.103:5454/test1.rtp" --sout=#transcode{vcodec=DIV3,vb=352,vfilter=croppadd{cropttop=20,cropbottom=30,paddleft=100}}:standard{access=http,mux=ts,dst="192.168.0.123:1234"} --run-time 28 vlc://quit


exit

