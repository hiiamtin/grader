#include<stdio.h>
int main() {
    int start, end, sum=0, i,temp;
    printf(" *** Sequence summation ***\n");
    printf("Enter start end : ");
    scanf("%d %d",&start,&end);
    //printf("start=%d end=%d\n",start,end);
    if(start>end) {
        temp = start;
        start = end;
        end = temp;
    }
    //printf("start=%d end=%d\n",start,end);
    printf("%d",start);
    sum = start;
    for(i=start+1; i<=end ; i++){
        sum+= i;
        printf(" + %d",i);

    }
  	if(sum<1000)
    	printf(" = %d\n",sum);
    else
        printf( " = %d,%03d\n",sum/1000,sum%1000);
    return 0;
}
