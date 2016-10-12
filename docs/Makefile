rebuild: clean build

.PHONY: clean build html pdf rebuild

clean:
	rm -rf build

build: html pdf

html: 
	cd en && make html LANG=en
	cd nl && make html LANG=nl

pdf: 
	cd en && make pdf LANG=en
	cd nl && make pdf LANG=nl
