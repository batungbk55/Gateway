@echo on
cd C:\Program Files (x86)\VideoLAN\VLC
vlc -vvv "http://192.168.0.165:12345/video2.mjpg" --sout=#transcode{vcodec=mp2v,vb="352",vfilter=croppadd{cropttop=20,cropbottom=30,paddleft=100}}:standard{access=file,mux=ts,dst="C:\xampp\htdocs\sigate\sg\truccanh\video\thanghien.mpg"} --run-time 50 vlc://quit

exit
