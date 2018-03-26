#-----------------------------------------------------------------
# File:
# Project: Project 1
# Author: Amanda Bsaibes, Alexander Coronado, Emmalee Keatley
# Date: 2/22/2018
# Section: 502
# E-mail 1: amanda.bsaibes@tamu.edu
# E-mail 2: kwong333@tamu.edu
# E-mail 3: emmaleepk@tamu.edu
#
# This file contains the initial test cases for the 
# database interaction with PHP. We first make sure that 
# the database is correctly set up and then test that 
# the PHP interacts as expected with the database
#
#-----------------------------------------------------------------

#imports for the libraries
import unittest
import pymysql.cursors

#setting up the database connection
connection = pymysql.connect(host='database.cse.tamu.edu',
                user='emmaleepk',
                password='csce315AAE',
                db='emmaleepk',
                charset='utf8mb4',
                cursorclass=pymysql.cursors.DictCursor,
                autocommit=True)

cursor = connection.cursor()

#this class performas the unit test cases
class TestStringMethods(unittest.TestCase):
    #-----------------------------------------------------------------
    # Name test_insert
    # PreCondition: Created table ProjectDB and a timestamp that you 
    # want to insert
    # PostCondition: Inserts a row into ProjectDB with the given 
    # timestamp
    #-----------------------------------------------------------------
    def test_insert(self):
        try:
            #try to execute the insert query
            cursor.execute("INSERT INTO ProjectDB () VALUES ()")
        except pymysql.ProgrammingError as e:
            #if this error is thrown then insert did not complete
            self.fail(msg=str(e))


    #-----------------------------------------------------------------
    # Name test_reset
    # PreCondition: Created table ProjectDB 
    # PostCondition: The table ProjectDB is reset and has it's auto
    # increment reset
    #-----------------------------------------------------------------
    def test_reset(self):
        try:
            #try to execute the delete and reset auto increment query
            cursor.execute("DELETE FROM `ProjectDB`")
            cursor.execute("ALTER TABLE `ProjectDB` AUTO_INCREMENT = 1")
        except pymysql.ProgrammingError as e:
            #if this error is thrown then the reset of the table failed
            self.fail(cursor.execute("DELETE FROM `ProjectDB"))

unittest.main(verbosity=2)
