## Table of contents

- [\Plinker\System\System](#class-plinkersystemsystem)

<hr />

### Class: \Plinker\System\System

> System information Some methods require root and not all work with windows.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>arch()</strong> : <em>string</em><br /><em>Get system architecture</em> |
| public | <strong>clear_swap()</strong> : <em>void</em><br /><em>Clear swapspace</em> |
| public | <strong>cpuinfo()</strong> : <em>void</em><br /><em>Get system CPU info output</em> |
| public | <strong>disk_space(</strong><em>string</em> <strong>$path=`'/'`</strong>)</strong> : <em>int</em><br /><em>Get diskspace</em> |
| public | <strong>disks(</strong><em>bool</em> <strong>$parse=true</strong>)</strong> : <em>string</em><br /><em>Get disk file system table</em> |
| public | <strong>distro()</strong> : <em>string</em><br /><em>Get system distro</em> |
| public | <strong>drop_cache()</strong> : <em>void</em><br /><em>Drop memory caches</em> |
| public | <strong>enumarate(</strong><em>array</em> <strong>$methods=array()</strong>)</strong> : <em>void</em> |
| public | <strong>hostname()</strong> : <em>string</em><br /><em>Get system hostname</em> |
| public | <strong>load()</strong> : <em>string</em><br /><em>Get system load</em> |
| public | <strong>logins(</strong><em>bool</em> <strong>$parse=true</strong>)</strong> : <em>string</em><br /><em>Get system last logins</em> |
| public | <strong>machine_id()</strong> : <em>string</em><br /><em>Get system machine-id - Generates one if does not have one (windows).</em> |
| public | <strong>memory_stats()</strong> : <em>array</em><br /><em>Get memory usage</em> |
| public | <strong>memory_total()</strong> : <em>int</em><br /><em>Get memory total bytes</em> |
| public | <strong>netstat(</strong><em>string</em> <strong>$option=`'-ant'`</strong>, <em>bool</em> <strong>$parse=true</strong>)</strong> : <em>string</em><br /><em>Get netstat output</em> |
| public | <strong>ping(</strong><em>string</em> <strong>$host=`''`</strong>)</strong> : <em>float</em><br /><em>Ping a server and return timing</em> |
| public | <strong>pstree()</strong> : <em>string</em><br /><em>Get system process tree</em> |
| public | <strong>reboot()</strong> : <em>void</em><br /><em>Reboot the system</em> |
| public | <strong>server_cpu_usage()</strong> : <em>int</em><br /><em>Get CPU usage in percentage</em> |
| public | <strong>system_updates()</strong> : <em>int 1=has updates, 0=no updates, -1=dunno</em><br /><em>Check system for updates</em> |
| public | <strong>top(</strong><em>bool</em> <strong>$parse=true</strong>)</strong> : <em>void</em><br /><em>Get system top output</em> |
| public | <strong>total_disk_space(</strong><em>string</em> <strong>$path=`'/'`</strong>)</strong> : <em>int</em><br /><em>Get total diskspace</em> |
| public | <strong>uname()</strong> : <em>string</em><br /><em>Get system name/kernel version</em> |
| public | <strong>uptime(</strong><em>string</em> <strong>$option=`'-p'`</strong>)</strong> : <em>void</em><br /><em>Get system uptime</em> |

