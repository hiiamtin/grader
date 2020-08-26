#include<stdio.h>
int main() {
  	char str[300];
  	int index;
  	printf(" *** ASCII string display ***\n");
  	printf("Enter a string : ");
  	scanf("%[^\n]",str);
  	printf("Output : [");
  	for(index = 0; str[index] !='\0';index++);
  	index--;
  	for(index--;index>0;index--)
      printf("|%d %c %x|,",str[index],str[index],str[index]);
    printf("|%d %c %x|",str[index],str[index],str[index]);
    printf("]");
	return 0;
}