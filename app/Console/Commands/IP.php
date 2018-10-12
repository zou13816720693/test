<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\DbDumper\Databases\MySql;
use Mail;

class IP extends Command
{
    /** @var string */
    protected $signature = 'ip:run';

    /** @var string */
    protected $description = 'ip拉黑命令';

    public function handle()
    {
        $this->line('开始拉黑ip');

        $this->abc();
        $this->line('完成');

    }

    public function abc()
    {
        $string = '80.75.14.218:37235
79.106.37.96:44108
185.102.130.31:53135
95.79.59.172:39311
190.115.9.113:52978
186.42.224.182:56675
117.240.175.51:52092
212.69.18.132:41347
109.172.149.56:35333
165.16.3.6:59244
45.229.100.18:57755
91.151.106.127:60801
46.209.216.194:45373
217.12.246.238:48551
178.18.65.194:37978
189.57.245.138:31086
92.46.109.74:39415
190.249.148.125:60956
120.29.124.97:48897
103.240.161.109:57161
122.154.65.26:45926
182.54.207.74:57745
36.91.48.82:52744
41.191.204.80:53629
178.169.245.72:45543
80.51.79.26:56725
202.93.128.98:36826
5.42.148.122:47220
45.77.51.23:54216
89.169.45.133:52223
114.69.235.98:35543
117.102.94.74:39805
62.148.144.216:60188
97.124.73.189:44772
103.216.82.211:48818
213.149.184.80:33189
81.18.214.62:51771
105.174.19.194:41734
81.28.53.9:62329
125.164.170.60:34516
182.253.204.155:42753
5.204.227.229:37016
202.21.98.138:56826
80.87.184.49:53805
70.169.150.235:52619
41.90.127.182:60881
103.111.81.99:46305
200.12.130.113:53854
189.113.103.137:39500
103.219.142.34:47493
103.216.82.213:33762
95.79.109.144:33855
42.115.34.107:42315
186.42.224.182:53160
193.19.165.222:39991
85.117.84.25:45671
103.219.142.34:48608
77.94.144.162:51099
86.34.158.116:44719
202.127.104.58:42592
200.12.130.113:53126
103.228.35.50:52040
194.190.24.74:33186
103.51.28.134:60386
81.28.53.9:22732
50.75.39.11:48978
95.167.241.242:55983
46.55.218.141:49682
213.108.120.2:59314
91.121.253.113:62193
188.170.52.91:60066
93.189.148.226:44688
193.227.49.82:58164
190.242.58.130:54613
82.193.123.230:41866
87.249.30.210:59185
91.222.117.82:41322
168.205.39.134:39161
181.129.69.106:35305
190.14.249.98:35637
178.250.92.18:55781
217.219.25.19:34912
43.224.8.86:60380
189.57.245.138:33873
54.39.19.46:37032
58.34.201.77:61589
94.154.31.136:45576
138.0.89.141:33154
103.205.26.100:48123
212.72.144.226:54554
138.185.8.10:35997
88.250.65.90:36136
201.6.109.189:43735
178.47.139.50:41163
180.250.107.2:54146
95.43.133.99:38555
177.72.92.24:57506
186.225.50.211:54140
85.217.137.77:43355
200.229.233.209:39533
188.166.3.41:54946
188.166.69.172:59879
125.164.170.60:34211
187.45.123.167:37076
95.161.179.186:57348
196.32.109.188:58876
202.169.252.14:46424
41.191.204.80:45856
128.199.157.103:44819
203.170.69.234:53314
46.22.48.61:46488
185.85.162.32:49889
47.254.35.118:38768
200.254.125.10:53148
82.138.29.246:52216
131.72.126.174:46640
186.34.32.89:58524
178.252.149.114:13720
45.77.51.23:54936
187.19.62.7:45140
212.210.133.34:54160
186.232.48.9:37646
81.18.214.62:50933
45.249.102.6:47586
27.116.51.108:48442
202.93.128.98:58761
189.57.245.138:28613
178.216.139.18:49035
202.58.108.58:48825
202.58.108.58:48790
51.38.130.141:44974
185.113.32.34:49786
187.32.8.12:40452
103.224.187.3:52133
103.216.82.211:60463
91.222.117.82:41134
178.254.155.54:50305
80.90.90.173:57122
202.93.128.98:50394
193.188.254.67:33272
202.152.31.194:36644
187.110.238.130:40837
118.97.85.217:43913
103.239.254.86:40440
185.91.190.90:51718
5.17.125.18:33270
203.176.140.178:52910
177.21.13.206:51632
167.99.221.158:40029
187.110.238.130:57595
183.91.87.40:51386
200.178.236.210:45151
177.101.122.178:46802
41.204.93.54:34727
128.199.164.35:48550
5.139.213.154:44919
178.252.149.114:4418
46.146.203.124:41182
103.76.142.14:39752
103.228.35.50:55985
212.69.18.132:39628
128.199.222.206:33228
177.128.224.2:54619
213.181.202.196:33097
129.205.96.45:53877
51.38.130.143:37216
71.78.173.26:47952
45.77.51.23:53382
46.37.120.141:38889
190.14.249.114:52216
178.252.149.114:14252
91.203.60.67:33460
89.212.18.76:59643
140.227.56.50:38906
95.43.200.59:48157
182.147.14.141:30208
62.176.126.66:43857
77.38.21.239:35514
5.35.93.157:57811
80.240.210.100:59599
201.151.230.68:48867
202.93.228.33:53660
200.254.125.10:52394
200.12.130.113:53426
200.254.125.10:51668
204.48.28.160:60176
41.191.204.80:42226
103.194.250.8:48058
209.97.164.154:37566
212.112.129.203:44847
103.240.161.109:38809
138.68.132.204:39497
31.134.16.53:38299
2.179.67.10:58754
42.61.52.116:41273
145.239.93.7:53436
46.31.105.238:46895
79.61.94.186:50762
193.33.166.28:39718
189.17.22.178:56837
92.62.72.183:50450
179.111.248.212:46974
95.210.191.156:39715
95.67.83.26:54258
83.243.66.36:35950
193.16.247.132:44020
213.145.137.102:59357
200.12.130.113:53990
200.254.125.10:49672
149.3.91.202:51087
88.247.38.178:53003
36.89.224.25:56534
181.143.16.226:48960
146.196.106.26:34468
83.242.255.41:58002
179.127.255.6:52344
94.158.153.85:56168
200.41.185.107:55624
188.126.62.225:60378
178.223.82.44:38479
92.255.196.91:48018
186.10.83.242:37516
170.80.146.2:56122
200.12.130.113:53258
41.75.76.75:44964
5.196.209.79:49814
164.77.134.10:40780
213.254.21.188:46447
145.14.160.254:51328
110.232.86.52:41067
212.12.31.26:58318
124.41.240.178:58963
118.172.205.192:34119
197.254.2.6:38805
125.166.154.241:53607
178.253.196.38:51347
109.110.73.106:45893
110.235.236.84:49160
74.143.193.83:38764
176.122.122.7:46935
180.210.205.53:47820
94.244.28.246:33188
36.89.186.221:45721
182.23.100.211:39156
43.250.81.140:60697
5.28.196.254:47889
115.78.125.45:49719
201.222.55.34:56751
82.135.211.232:42838
117.240.210.155:35745
81.28.53.9:30501
190.242.119.67:59620
150.242.106.42:49740
128.199.242.173:36182
159.224.220.249:45114
177.126.88.62:55048
27.116.51.108:48767
41.190.139.46:47972
200.254.125.10:53596
62.217.168.237:52015
145.239.93.7:53968
81.6.48.201:47999
212.154.58.85:35815
103.216.82.211:45880
14.204.63.70:49795
41.180.1.146:36322
188.35.167.7:42708
202.152.40.28:46055
78.38.115.210:60379
202.21.98.138:59455
85.100.108.84:37761
114.141.49.147:57304
62.80.191.90:33568
202.182.57.10:59692
190.214.16.230:50322
190.0.35.6:43749
139.255.16.171:45502
85.111.25.113:40572
103.219.142.34:53617
88.87.70.84:35117
82.214.139.98:57084
12.183.155.185:47822
178.252.149.114:21974
69.63.73.172:58163
46.10.241.140:37023
164.160.7.46:44007
95.38.171.52:27206
101.255.124.35:43435
103.216.82.213:47809
145.239.85.202:40474
186.42.224.182:55360
31.41.94.217:45066
185.82.96.10:60613
88.200.225.136:42693
82.117.199.254:37495
93.126.36.1:47423
148.243.37.101:54063
200.12.130.113:53708
159.203.45.186:38470
5.167.51.235:48244
103.240.161.109:55576
89.169.189.173:48241
86.57.220.166:59178
51.38.130.143:35535
123.255.250.114:57427
145.239.90.203:45296
83.246.139.24:41000
180.94.87.157:55792
140.227.82.89:40396
186.137.166.139:42530
105.112.89.238:50937
194.190.106.69:35320
193.77.45.19:34166
213.6.67.126:58869
179.49.8.2:50109
166.143.193.162:59610
186.47.103.198:59891
78.38.115.210:60469
217.218.234.254:48002
203.188.252.158:33604
94.25.104.250:42483
103.195.24.83:39780
160.119.211.73:38221
190.196.235.247:54505
185.205.236.190:41188
54.201.200.187:52806
180.210.205.198:29229
27.116.51.115:49905
178.136.211.115:32963
185.82.96.10:10298
46.55.216.252:39138
210.209.93.143:57947
94.158.153.85:60638
176.35.51.2:55646
186.42.224.182:54394
190.14.235.50:53813
201.183.249.226:35885
31.129.170.186:42998
110.232.76.164:55954
212.76.6.114:57560
145.239.93.7:52852
36.89.227.34:50684
62.117.92.180:53879
170.84.51.74:50266
189.57.245.138:61506
188.191.29.15:57891
187.110.238.130:43525
129.205.210.90:60226
200.105.107.57:43812
212.69.18.132:60276
212.115.234.114:47670
194.44.160.246:38925
134.236.252.126:43836
80.240.210.100:58894
45.77.51.23:55532
5.20.255.82:58746
43.228.222.114:44181
103.31.45.172:52310
45.227.115.181:42817
90.224.68.175:39156
80.245.117.130:51088
178.136.234.22:38256
189.51.96.226:34581
125.166.154.241:49173
202.179.190.210:49951
213.181.202.24:52656
94.156.59.235:33987
90.173.50.18:38814
185.108.141.49:37815
200.149.1.106:41616
185.63.197.48:51960
159.89.103.7:52950
176.120.203.223:33667
217.116.60.66:36092
106.11.248.209:80
189.170.3.20:34210
193.107.247.98:34716
181.191.135.251:36681
85.207.217.166:32807
189.57.245.138:44356
217.113.146.34:37872
95.38.171.52:13118
186.42.224.182:55659
188.125.42.112:57686
151.24.237.124:52012
145.239.85.202:45416
89.169.203.222:40742
217.12.112.46:54664
88.255.101.249:45073
43.224.8.86:56462
46.229.67.198:34062
82.147.84.78:34597
43.245.184.202:57413
118.97.85.217:43849
43.224.8.86:40151
36.5.161.115:8095
45.123.41.210:33396
103.17.213.174:47623
119.82.253.32:46053
103.25.166.154:47537
197.45.109.123:38119
31.134.122.92:40690
217.117.24.6:48641
201.184.138.42:57236
92.51.92.229:43488
194.146.230.9:45438
124.153.16.30:50544
196.32.109.188:58612
78.156.42.40:38276
200.12.130.113:53566
41.191.204.80:44737
138.36.200.28:38734
91.194.206.137:58969
182.52.226.124:44436
31.202.20.103:41254
37.10.74.14:54117
119.2.41.10:40199
85.237.56.193:54718
187.32.8.12:40652
185.85.162.32:53315
166.143.193.162:59748
178.252.149.114:6329
43.224.8.86:33346
182.180.62.55:54099
80.91.187.170:55320
149.56.69.5:63067
103.214.80.34:38079
54.37.136.240:42842
186.42.224.182:54993
200.254.125.10:52046
190.14.249.138:45642
212.93.121.96:44533
103.219.142.34:43612
129.205.96.45:46238
200.254.125.10:51194
195.190.100.90:51978
202.57.10.154:58166
179.127.140.188:48340
182.253.209.203:47795
71.13.140.89:58056
213.6.68.190:53541
54.38.52.131:54266
95.38.171.52:16951
89.165.218.82:41845
45.77.51.23:52642
200.12.130.113:54112
27.116.51.114:54529
185.82.96.10:40752
91.191.33.170:34390
138.97.145.33:36555
41.74.9.238:53600
41.180.1.146:36303
185.164.111.197:45869
31.130.108.142:50897
185.34.23.78:53197
186.42.224.182:54106
217.20.174.145:45550
202.125.94.139:48793
185.85.162.32:52457
176.192.20.146:34573
89.239.25.218:54868
138.197.103.51:60736
217.27.219.14:59564
95.38.171.52:3333
189.84.126.193:46834
189.57.245.138:63995
36.66.61.155:56909
194.243.194.51:50362
95.216.15.79:58501
88.87.70.84:58486
78.188.119.210:40276
45.77.51.23:56406
185.14.250.215:46704
202.183.201.7:39930
175.101.80.134:48819
200.254.125.10:52762
45.77.51.23:50764
103.240.109.171:40054
94.45.144.197:46876
145.239.93.7:53532
177.66.184.50:46795
125.166.154.241:51564
159.203.58.149:54428
45.125.223.10:34365
185.164.111.197:45448
46.196.24.70:43999
95.164.74.27:54504
43.224.8.86:43544
110.232.86.6:44748
187.110.238.130:59184
118.174.65.65:34406
77.237.15.225:55362
94.43.189.184:59136
212.76.6.114:58399
143.208.57.51:45653
62.176.12.34:43136
91.150.67.221:37277
154.72.202.62:44585
83.18.178.185:39810
187.110.238.130:47396
2.179.67.10:58428
114.130.93.6:52134
190.12.48.158:47446
45.65.250.222:42981
88.118.131.30:37174
178.215.76.193:43023
185.51.139.207:35576
27.116.51.108:48646
176.115.197.118:43827
117.135.0.166:43827
162.243.140.150:24660
103.228.35.50:57983';
        $array = explode("\n",$string);
        $ip = [];
        foreach($array as $value) {
            $ip[] = substr($value,0,strrpos($value,':'));
        }
        $ip = array_unique($ip);

        $this->line('共'.count($ip));
        foreach($ip as $value) {

            //$this->line("iptables -A INPUT -p tcp -s $ip --dport 80 -j DROP;");
             exec("iptables -A INPUT -p tcp -s $value --dport 80 -j DROP;");
            //exec("iptables -D INPUT -p tcp -s $value --dport 80 -j DROP");
        }
    }


}


