#include <sys/types.h>
#include <sys/stat.h>
#include <sys/wait.h>
#include <errno.h>
#include <fcntl.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <syslog.h>
#include <unistd.h>

/* TODO:
 * - There is a pretty obvious buffer overflow in the fact that signature
 *   is 1024 bytes.  However, since REAL_SIGNATURE is predefined and
 *   fortune is in a system directory, exploiting it may be difficult.
 */

#define FORTUNE "/usr/games/fortune -s"
#define MAXLINE 81
#define REAL_SIGNATURE \
"  Steven Engelhardt <sengelha@uiuc.edu>\n"\
"  http://www.uiuc.edu/ph/www/sengelha\n"\
"\n"

static char signature[1024];

int check_cla(int argc, char* argv[])
{
  if (argc != 2) {
    return -1;
  }

  return 0;
}

int daemon_init(void)
{
  pid_t pid;

  if ((pid = fork()) < 0) {
    return -1;
  } else if (pid != 0) {
    exit(0); /* parent exits */
  }

  setsid();
  chdir("/");
  umask(0);

  return 0;
}

void create_fifo(char* filename)
{
  syslog(LOG_NOTICE, "%s is not a FIFO.  Attempting to make it into one.", filename);

  if (mknod(filename, S_IFIFO | 0600, 0) == -1) {
    syslog(LOG_ERR, "mknod error for %s: %s", filename, strerror(errno));
    exit(EXIT_FAILURE);
  }
}

void check_fifo(char* filename)
{
  struct stat buf;

  if (stat(filename, &buf) == -1) {
    create_fifo(filename);
    if (stat(filename, &buf) == -1) {
      syslog(LOG_ERR, "stat error for %s: %s", filename, strerror(errno));
      exit(EXIT_FAILURE);
    }
  }

  if (!S_ISFIFO(buf.st_mode)) {
    if (unlink(filename) == -1) {
      syslog(LOG_ERR, "unable to unlink %s: %s", filename, strerror(errno));
      exit(EXIT_FAILURE);
    }

    create_fifo(filename);
  }
}

void create_rand_sig(void)
{
  FILE* fp;
  char line[MAXLINE];

  strcpy(signature, REAL_SIGNATURE);

  if ((fp = popen(FORTUNE, "r")) == NULL) {
    syslog(LOG_ERR, "popen error: %m");
    exit(EXIT_FAILURE);
  }

  while (fgets(line, MAXLINE, fp) != NULL) {
    strcat(signature, "  ");
    strcat(signature, line);
  }

  if (ferror(fp)) {
    syslog(LOG_ERR, "fgets error: %m");
    exit(EXIT_FAILURE);
  }

  if (pclose(fp) == -1) {
    syslog(LOG_ERR, "pclose error: %m");
    exit(EXIT_FAILURE);
  }
}

void monitor_fifo(char* filename)
{
  while (1) {
    int fd;

    check_fifo(filename);
  
    create_rand_sig(); 

    if ((fd = open(filename, O_WRONLY)) == -1) {
      syslog(LOG_ERR, "open error for %s: %s", filename, strerror(errno));
      exit(EXIT_FAILURE);
    }

    if (write(fd, signature, strlen(signature)) == -1) {
      syslog(LOG_ERR, "write error for %s: %s", filename, strerror(errno));
      exit(EXIT_FAILURE);
    }

    (void) close(fd);

    sleep(1);  /* to avoid dup sigs */
  }
}

int main(int argc, char* argv[])
{
  if (check_cla(argc, argv)) {
    fprintf(stderr, "%s: Usage error\n", argv[0]);
    return -1;
  }

  if (daemon_init()) {
    fprintf(stderr, "%s: Error initializing daemon\n", argv[0]);
    return -1;
  }

  monitor_fifo(argv[1]);

  return 0;
}
