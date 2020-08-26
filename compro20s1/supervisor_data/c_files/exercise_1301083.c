#include<stdio.h>
int main() {
    int n;
    printf("ASCII number (66-91) : ");
    scanf("%d",&n);
    n--;
    printf("Previous character --> %c (%d)\n",n,n);
  
	return 0;
}