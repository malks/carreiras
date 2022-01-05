from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re



if __name__ == "__main__":
    #Instancia Conexões Principais
    main_sql_conn=sql_conn()

    #Desativa vagas fora de período de recrutamento
    #run_sql("UPDATE lunellicarreiras.jobs SET lunellicarreiras.jobs.status=0 WHERE lunellicarreiras.jobs.status=1 AND NOW() NOT BETWEEN lunellicarreiras.jobs.start AND lunellicarreiras.jobs.end",main_sql_conn)

    run_sql("UPDATE jobs j JOIN subscribed subs ON subs.job_id=j.id JOIN subscribed_has_states substates ON substates.subscribed_id=subs.id AND substates.state_id=2 SET subs.active=0 WHEREj.status='0'",main_sql_conn)