#include<stdio.h>
int main() {
  	char str[300];
  	int index;
  	printf(" *** ASCII string display ***\n");
  	printf("Enter a string : ");
  	scanf("%[^\n]",str);
  	printf("Output : ");
  	for(index = 0; str[index] !='\0';index++)
      printf("|%d,%c| ",str[index],str[index]);
      
	return 0;
}