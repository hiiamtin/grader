#include<stdio.h>
int main() {
  	int n,i,j;
  	printf("input : ");
    scanf("%d",&n);
    if (n<0) 
      printf("Invalid input!!!");
    else {
    for (i=0;i<=n;i++){
      for(j=0;j<i;j++)
        printf("*");
      for(j=0;j<2*(n-i);j++)
        printf(" ");
       for(j=0;j<i;j++)
        printf("*");
        printf("\n");
    }
  
    for (i=n-1;i>0;i--){
      for(j=i;j>0;j--)
        printf("*");
      for(j=0;j<2*(n-i);j++)
        printf(" ");
       for(j=i;j>0;j--)
        printf("*");
       printf("\n");
      
    } 
    }
	return 0;
}