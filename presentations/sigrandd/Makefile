CC=gcc
CFLAGS=-Wall -O2
DVIPS=dvips
LATEX=latex
SGML2HTML=sgml2html
SGML2LATEX=sgml2latex
LD=$(CC)
LDFLAGS=$(CFLAGS)

TARGET = sigrandd
OBJS = sigrandd.o

all: $(TARGET) $(TARGET).ps $(TARGET).html

clean:
	$(RM) $(TARGET).tex $(TARGET).dvi $(TARGET).ps $(TARGET).log $(TARGET).aux $(TARGET)*.html $(TARGET).toc missfont.log $(TARGET) $(OBJS)

$(TARGET): $(OBJS)
	$(LD) $(LDFLAGS) -o $(TARGET) $(OBJS)

$(TARGET).html: $(TARGET).sgml
	$(SGML2HTML) $(TARGET).sgml

$(TARGET).ps: $(TARGET).dvi
	$(DVIPS) -o $(TARGET).ps $(TARGET).dvi

$(TARGET).dvi: $(TARGET).tex
	$(LATEX) $(TARGET).tex
	$(LATEX) $(TARGET).tex
	$(LATEX) $(TARGET).tex

$(TARGET).tex: $(TARGET).sgml
	$(SGML2LATEX) $(TARGET).sgml
