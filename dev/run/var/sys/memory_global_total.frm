TYPE=VIEW
query=select `sys`.`format_bytes`(sum(`performance_schema`.`memory_summary_global_by_event_name`.`CURRENT_NUMBER_OF_BYTES_USED`)) AS `total_allocated` from `performance_schema`.`memory_summary_global_by_event_name`
md5=8082fddb38d6165c0d33b88815ddf3d8
updatable=0
algorithm=1
definer_user=mysql.sys
definer_host=localhost
suid=0
with_check_option=0
timestamp=2022-01-03 00:07:14
create-version=1
source=SELECT sys.format_bytes(SUM(CURRENT_NUMBER_OF_BYTES_USED)) total_allocated FROM performance_schema.memory_summary_global_by_event_name
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `sys`.`format_bytes`(sum(`performance_schema`.`memory_summary_global_by_event_name`.`CURRENT_NUMBER_OF_BYTES_USED`)) AS `total_allocated` from `performance_schema`.`memory_summary_global_by_event_name`
