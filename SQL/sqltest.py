#! /usr/bin/python
import mysql.connector

cnx = mysql.connector.connect(user='root', password='AdminCompro',host='localhost',database='compro20s1')
cnx.close()