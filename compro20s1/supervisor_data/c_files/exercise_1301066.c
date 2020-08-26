#include<stdio.h>
int main() {
  int n;
  printf(" *** switch control structure ***\n");
  printf("Enter a number : ");
  scanf("%d",&n);
  switch(n%7) {
    case 0 : printf("Hello, world!\n");
      break;
    case 1 :
      printf("Hello, what a wonderful world!\n");
      break;
    case 2 :
      printf("Hello, it is a beautiful day.\n");
      break;
    default :
      printf("You are the wind beneath my wings.");
  }
	return 0;
}