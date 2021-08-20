#!/usr/bin/python3
# -*- coding: utf-8 -*-
import os
import cx_Oracle

home=str(os.path.expanduser("~"))
f=open(os.path.join(os.path.expanduser("~"),".oracle_carreiras_database_credentials"),"r")
  
fdata={}
condata={}

for x in f:
  fdata[str(x.split('=')[0]).strip()]=str(x.split('=')[1]).strip()

dsn = cx_Oracle.makedsn(fdata['host'], fdata['port'], service_name=fdata['service_name'])
condata['dsn']=dsn
condata['user']=fdata['user']
condata['password']=fdata['password']

def run_select(select,conn):
    result = []
    cursor = conn.cursor()
    cursor.execute(select)
    cursor.rowfactory = lambda *args: dict(zip([d[0] for d in cursor.description], args))
    result=cursor.fetchall()
    return result


def run_sql(sql,conn):
    cursor = conn.cursor()
    cursor.execute(sql)
    conn.commit()
    return True


def new_conn():
  conn = cx_Oracle.connect(
    user=condata['user'], 
    password=condata['password'], 
    dsn=condata['dsn'],
    encoding="UTF-8"
  )
  cursor = conn.cursor()
  cursor.execute('ALTER SESSION SET nls_date_Format = "YYYY-MM-DD:HH24:MI:SS"')
  return conn