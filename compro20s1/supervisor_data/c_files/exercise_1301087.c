#include<stdio.h>
int main() {
  	int num,i,j,count = 1;
  	printf("input : ");
  	scanf("%d",&num);
  	printf("\n");
  	for (i=1;i<=num;i++) {
      for (j=1;j<=num;j++) {
      	printf("%4d",count);
        count += 1;
      }
      printf("\n");
        
    }
      
	return 0;
}