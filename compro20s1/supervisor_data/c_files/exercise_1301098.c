#include<stdio.h>
int main() {
	int year, flag=0; // 0 is common year, 1 is leap year
	printf(" *** Leap year checking ***\n");
	printf("Enter year in BC (1000-3000) : ");
	scanf("%d",&year);
	if( year<1000 || year>3000) {
		printf("%4d is NOT in the range (1000-3000).\n", year);
		return 0;
	}
	if (year%4 ==0)
		flag = 1;
	if (year%100 == 0)
		flag = 0;
	if(year%400== 0)
		flag = 1;
	if(flag)
		printf("%4d is a leap year.\n", year);
	else
		printf("%4d is a common year.\n", year);
	return 0;
}