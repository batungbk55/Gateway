@echo on 
cd C:\Program Files\VideoLAN\VLC
vlc -vvv "http://192.168.0.119:1234" --sout=#transcode{vcodec=mp2v,vb="280",vfilter=croppadd{cropttop=0,cropbottom=0,paddleft=0}}:standard{access=file,mux=ts,dst="C:\xampp\htdocs\web\sg\truccanh\video\thanghien.mpg"} --run-time 50 vlc://quit 
exit