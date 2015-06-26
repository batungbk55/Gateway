@echo on 
cd C:\Program Files\VideoLAN\VLC
vlc -vvv "rtsp://192.168.0.119:5454/test1.rtp" --sout "#transcode{vcodec=mp4v,acodec=mpga,vb=280}:standard{access=http,mux=ogg,dst=192.168.0.119:1234}" run-time 10 vlc://quit
exit