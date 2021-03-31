#### Monitoring Processes with Supervisord

```
$ apt-cache show supervisor
```

```
$ sudo apt-get install -y supervisor
```

```
$ sudo service supervisor start
```

```
$ nano /etc/supervisor/supervisord.conf
```

```
[inet_http_server]
port = 9001
```

```
$ supervisorctl reread
$ supervisorctl update
$ supervisorctl
$ restart all
```

```
$ nano /etc/supervisor/conf.d/beagle-worker.conf
```

```
[program:beagle-worker]
command=php /root/Beagle/bin/console app:worker
user=root
numprocs=5
startsecs=0
autostart=true
autorestart=true
process_name=%(program_name)s_%(process_num)02d
```

[Monitoring Processes with Supervisord]](https://serversforhackers.com/c/monitoring-processes-with-supervisord)
