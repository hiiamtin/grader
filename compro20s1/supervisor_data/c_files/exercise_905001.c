#include<stdio.h>
#include<string.h>


void number2word(int i,char *ch) {
    char word[10][15]={"zero","one","two","three","four","five","six","seven","eight","nine"};
    strcpy(ch,word[i]);
}


int main() {
    char phone_number[15],str[15]="nothing";
    int i;
    printf("*** Number to words ***\n");
    printf("Enter phone number : ");
    scanf("%s",phone_number);
    printf("%s ==> ",phone_number);
    for(i=0;phone_number[i] != '\0';i++) {
        number2word(phone_number[i]-0x30,str);
        printf("%s ",str);
    }
    printf("\n");
    return 0;
}