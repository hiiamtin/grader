#include<stdio.h>
int min;
int max;
void computeMinMax(int,int,int,int);
int main() {
  	int a,b,c,d;
  	printf(" *** Find Min and Max value of 4 inputs ***\n");
   	printf("Enter 4 integers : ");
  	scanf("%d %d %d %d",&a,&b,&c,&d);
  	computeMinMax(a,b,c,d);
  	printf("The minimum number is %d\n",min);
    printf("The maximum number is %d\n",max);
	return 0;
}
void computeMinMax(int num1,int num2,int num3,int num4) {
    //compute min
    min = num1;
    if(num2<min)
        min=num2;
    if(num3<min)
        min=num3;
    if(num4<min)
        min=num4;

     //compute max
    max = num1;
    if(num2>max)
        max = num2;
    if(num3>max)
        max = num3;
    if(num4>max)
        max = num4;

}
