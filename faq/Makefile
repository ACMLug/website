all: uiuc.sw.linux.html uiuc.sw.linux.txt uiuc.sw.linux.tex uiuc.sw.linux.dvi uiuc.sw.linux.ps uiuc.sw.linux.pdf

spell: uiuc.sw.linux.sgml
	ispell uiuc.sw.linux.sgml

clean:
	rm -f uiuc.sw.linux*html uiuc.sw.linux.txt *~ *.bak *.log *.aux *.dvi *.ps *.toc *.tex *.rtf

check: uiuc.sw.linux.sgml
	sgmlcheck uiuc.sw.linux.sgml

uiuc.sw.linux.html: uiuc.sw.linux.sgml
	sgml2html uiuc.sw.linux.sgml

uiuc.sw.linux.txt: uiuc.sw.linux.sgml
	sgml2txt -f uiuc.sw.linux.sgml

uiuc.sw.linux.tex: uiuc.sw.linux.sgml
	sgml2latex uiuc.sw.linux.sgml

uiuc.sw.linux.dvi: uiuc.sw.linux.tex
	latex uiuc.sw.linux.tex
	latex uiuc.sw.linux.tex
	latex uiuc.sw.linux.tex

uiuc.sw.linux.ps: uiuc.sw.linux.dvi
	dvips -o uiuc.sw.linux.ps uiuc.sw.linux.dvi

uiuc.sw.linux.pdf: uiuc.sw.linux.ps
	ps2pdf uiuc.sw.linux.ps uiuc.sw.linux.pdf
