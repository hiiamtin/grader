#include<stdio.h>
#include<ctype.h>
#include<string.h>
#define SIZE 33
int validate(char *s,int base_n) {
    int i=0,test=-1;
    char *ch=s;
    //printf("%c\n",*ch);
    //printf("%s\n",ch);

    while(ch[i] != '\0' && i<SIZE) {
        //change the character to number 0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15
        //printf("ch[%d]=%c \n",i,ch[i]);

        if (ch[i] >= '0' && ch[i] < '9') {
            test = ch[i]-'0';
            //printf("%c %d\n",ch[i],test);

        } else if (toupper(ch[i]) == 'A'){
            test = 10;
        } else if (toupper(ch[i]) == 'B'){
            test = 11;
        } else if (toupper(ch[i]) == 'C'){
            test = 12;
        } else if (toupper(ch[i]) == 'D'){
            test = 13;
        } else if (toupper(ch[i]) == 'E'){
            test = 14;
        } else if (toupper(ch[i]) == 'F'){
            test = 15;
        } else {
            test = -1;
        }

        //printf("ch[%d]=%c test=%d\n",i,ch[i],test);

        if (!(test>=0 && test < base_n))
            return 0; //false

        //printf("%c is valid.\n",*ch);
        i++;
    }

    return 1; // true

}

int convert2decimal(char *s, int base_n) {
    int num=0,length=0,i,mul=1,test;
    char *ch = s;
    for(i=0;ch[i]!='\0';i++){
        //printf("ch[%d] = %c \n",i,ch[i]);
        length++;
    }
    //printf("%s -> %d\n",ch, length);

    for(i=length-1; i>=0; i--) {
        //change the character to number 0 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15
        //printf("ch[%d]=%c \n",i,ch[i]);

        if (ch[i] >= '0' && ch[i] < '9') {
            test = ch[i]-'0';
            //printf("%c %d\n",ch[i],test);

        } else if (toupper(ch[i]) == 'A'){
            test = 10;
        } else if (toupper(ch[i]) == 'B'){
            test = 11;
        } else if (toupper(ch[i]) == 'C'){
            test = 12;
        } else if (toupper(ch[i]) == 'D'){
            test = 13;
        } else if (toupper(ch[i]) == 'E'){
            test = 14;
        } else if (toupper(ch[i]) == 'F'){
            test = 15;
        } else {
            test = -1;
        }
        num += test*mul;
        mul *= base_n;

    }
    //printf("%s(%d) -> %d\n",ch,base_n, num);


    return num;
}


int main() {
    char str1[SIZE],str2[SIZE];
    int base_n,num1,num2;
    printf(" *** Base n Calculator ***\n");
    printf("Enter num1 num2 n : ");
    scanf("%s %s %d",str1, str2, &base_n);
    //validate input
    if (!validate(str1,base_n)) {
        printf("%s is NOT valid.\n",str1);
        return 0;
    }
    if (!validate(str2,base_n)) {
        printf("%s is NOT valid.\n",str2);
        return 0;
    }
    if (!(base_n>=2 && base_n<=16)) {
        printf("base_n(%d) is NOT valid.\n",base_n);
        return 0;
    }
    num1 = convert2decimal(str1, base_n);
    num2 = convert2decimal(str2, base_n);

    printf("%s + %s (%d) = %d + %d (decimal) = %d (decimal)\n",str1,str2,base_n,num1,num2, num1+num2);


    return 0;
}
