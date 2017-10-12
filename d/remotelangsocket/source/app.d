module remotelangsocket;

import std.stdio;
import std.socket;

void main() {
    Socket server = new TcpSocket();
    server.setOption(SocketOptionLevel.SOCKET, SocketOption.REUSEADDR, true);
    server.bind(new InternetAddress(8080));
    server.listen(1);

    while(true) {
        Socket client = server.accept();
        
        string response = "<?php print 'Hello World!!';";
        client.send(response);

        client.shutdown(SocketShutdown.BOTH);
        client.close();
    }
}
