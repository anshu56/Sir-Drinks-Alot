#! /usr/bin/env python
import urllib
import re
import string
from socket import *

def main():
	#sqlcommands
	mixedDrinkCategoryList = ['Cocktail','Cocoa','Coffee / Tea','Homemade Liqueur','Milk / Float / Shake', 'Ordinary Drink', 'Punch / Party Drink','Soft Drink / Soda','Other/Unknown']
	alcoholicPattern = re.compile(r'<small>Alcohol:.*\n.*</small></TD></TR>')
	categoryPattern = re.compile(r'<small>Category:.*\n.*</small></TD></TR>')
	alcoholicDict = dict()
	for i in xrange(0,515):
		print i
		startURL = "http://www.webtender.com/db/ingred/"+str(i)
		usock = urllib.urlopen(startURL)
		HTMLpage = usock.read()
		usock.close()
		title = (re.findall(r'<TITLE>.*</TITLE>', HTMLpage))[0]
		title = string.replace(title,'<TITLE>','')
		title = string.replace(title,'</TITLE>','')
		title = string.replace(title,' (The Webtender)','')
		if(not title == 'The Webtender: 404 Not found'):
			alcoholic = re.findall(r'<STRONG>Alcohol:</STRONG>.*</DL>',HTMLpage,re.DOTALL)[0]
			alcoholic = re.sub('<STRONG>Alcohol:</STRONG>\n<DD>','',alcoholic)
			alcoholic = re.sub('\n</DL>','',alcoholic)
			alcoholic = string.strip(alcoholic)
			if(not alcoholic == "Non alcoholic"):
				alcoholicDict[title] = 1
			else:
				alcoholicDict[title] = 0
			#print alcoholic
	#print alcoholicDict
	with open('sql.txt','w') as f:
		for i in xrange(0,6500):
			startURL = "http://www.webtender.com/db/drink/"+str(i)
			usock = urllib.urlopen(startURL)
			HTMLpage = usock.read()
			usock.close()
			#print HTMLpage
	
	
			title = (re.findall(r'<TITLE>.*</TITLE>', HTMLpage))[0]
			title = string.replace(title,'<TITLE>','')
			title = string.replace(title,'</TITLE>','')
			title = string.replace(title,' (The Webtender)','')
			if(not (title == 'The Webtender: 404 Not found' or title == 'The Webtender: 410 Gone')):
				alcoholic = alcoholicPattern.findall(HTMLpage)[0]
				alcoholic = string.replace(alcoholic,'<small>Alcohol:</small></TH>\n<TD><small>','')
				alcoholic = string.replace(alcoholic,'</small></TD></TR>','')
				if alcoholic == 'Alcoholic':
					#print title
					ingreds = re.findall(r'<LI>.*CLASS=ingr.*</A>',HTMLpage)
					for ingred in ingreds:
						ingred = string.replace(ingred,"<LI>",'')
						ingred = string.replace(ingred,"</A>",'')
						ingred = re.split('<A.*>',ingred)
						#drink = string.replace(drink,r'<A.*>','')
						if ingred[1] in alcoholicDict:
							alcoholicDrink = alcoholicDict[ingred[1]]
						else:
							alcoholicDrink = 0
						sql = "INSERT INTO Makes (TypeName,Drinkname,Quantity,Alcoholic) VALUES ('{typeName}','{drink}','{quantity}',{alcoholic})"
						sql = sql.format(typeName=ingred[1],drink=title,quantity = ingred[0],alcoholic = alcoholicDrink)
						f.write(sql+'\n')
						#print sql
					#instructions = instructionsPattern.findall(HTMLpage,re.DOTALL)[0]
					instructions = re.findall(r'<H3>Mixing instructions:</H3>.*</P>',HTMLpage,re.DOTALL)[0]
					instructions = string.replace(instructions,'<H3>Mixing instructions:</H3>','')
					instructions = string.replace(instructions,'<P>','')
					instructions = string.replace(instructions,'</P>','')
					comments = re.findall(r'<H3>Creator.*',instructions,re.DOTALL)
					if(len(comments)>0):
						instructions = string.replace(instructions,comments[0],'')
					instructions = re.sub('\n','',instructions)
					#print ""
					#print '\t'+instructions
					#print ""
					category = categoryPattern.findall(HTMLpage)[0]
					category = string.replace(category,'<small>Category:</small></TH>\n<TD NOWRAP><small>','')
					category = string.replace(category,'</small></TD></TR>','')
					if(category in mixedDrinkCategoryList):
						category = "Mixed Drink"
					#print ""
					#print '\t'+category
					#print ""
					
					sql = "INSERT INTO Drinks (DrinkName,Category,Recipe) VALUES ('{Name}','{Category}','{Recipe}')"
					sql = sql.format(Name=title,Category=category,Recipe=instructions)
					f.write(sql+'\n')
					print i	
					#print sql
					#print sql
					#sql = "INSERT INTO Makes (TypeName,Drinkname,Quantity) VALUES ('$type','$drink','$quantity')"
					

if __name__ == "__main__":
    main()
