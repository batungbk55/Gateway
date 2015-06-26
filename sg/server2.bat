@echo on
cd C:\Program Files (x86)\VideoLAN\VLC
vlc -vvv "rtsp://192.168.1.101:5454/test1.rtp" --sout "#transcode{vcodec=mp4v,acodec=mpga,vb=300,ab=128}:standard{access=http,mux=ogg,dst=192.168.1.108:12345}"

exit

