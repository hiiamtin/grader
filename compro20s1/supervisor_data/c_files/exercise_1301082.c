#include<stdio.h>
int main() {
    int n,r,c,display=1;
    printf("Input : ");
    scanf("%d",&n);
    if(n<=0) {
      printf("No Answer\n");
      return 0;
    }
   	for(r=1;r<=n;r++) {
      for(c=1;c<=r;c++) {
        printf("%4d",display);
        display +=2;
      }
      printf("\n");
    }
	return 0;
}