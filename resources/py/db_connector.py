import mysql.connector

def insertIntoDB(sql, val):
    mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="venavermedb"
    )

    mycursor = mydb.cursor()
    mycursor.executemany(sql, val)
    mydb.commit()
    
    mycursor.close()
    mydb.close()