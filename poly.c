#include <stdio.h>
#include <assert.h>
#include "poly.h"
#include <math.h>

int main(void)
{
	struct poly *p0 = polySetCoefficient (polySetCoefficient 
		(polySetCoefficient (polyCreate(), 0, 4.0), 1, -1.0), 10, 2.0);
	struct poly *p1 = polyCopy (p0);
	struct poly *p2, *p3, *p4;

	printf("%g\n", polyGetCoefficient (p0, 10));
	printf("%g\n", polyGetCoefficient (p0, 100));
	printf("%d\n", polyDegree (p0));
	polyPrint (p0);
	polyPrint (p1);
	polySetCoefficient (p1, 2, 1.0/2.0);
	polyPrint (p1);
	p2 = polyAdd (p0, p1);
	polyPrint (p2);
	p3 = polyMultiply (p0, p1);
	polyPrint (p3);
	p4 = polyPrime (p3);
	polyPrint (p4);
	printf ("%g\n", polyEval (p0, 0.0));
	printf ("%g\n", polyEval (p0, 1.0));
	printf ("%g\n", polyEval (p0, 2.0));
	p0 = polyDelete (p0);
	p1 = polyDelete (p1);
	p2 = polyDelete (p2);
	p3 = polyDelete (p3);
	p4 = polyDelete (p4);
	printf("\n");
}

void *safeMalloc(size_t size){
	void *p = malloc(size);
	assert (p);
	return p;
}

void *safeRealloc(void *ptr, size_t size){
	void *p = (void*)realloc(ptr, size);
	assert (p);
	return p;
}

struct poly *polyCreate(){

	struct poly *a =(struct poly *)safeMalloc(sizeof(struct poly));	
	a->mypoly = (double *) safeMalloc(sizeof(double));
	a->length = 0;
	a->size = 1;
	return a;
}

struct poly *polyDelete(struct poly *p){

	if (p) {
		free(p->mypoly);
		free(p);
	}
	return (struct poly *)0;
}

struct poly *polySetCoefficient (struct poly *p, int i, double value){
	
	if (p == (struct poly *)0 || i < 0)
		return 0;
	if (i >= p->size){
		do
			p->size *= 2;
		while (i >= p->size);
		p->mypoly = (double *) safeRealloc((void *) p->mypoly, p->size*sizeof(double));
	}

	while(i >= p->length) {
		
		/*sets zeros for empty coefficient spaces*/
		p->mypoly[p->length] = 0;   
		p->length++;
	}
	
	/*sets the coefficient at i to the given value*/
	p->mypoly[i] = value;
	return p;
}

double polyGetCoefficient (struct poly *p, int i){

	if (p == (struct poly *)0 || (i < 0) || (i >= p->length))
		return 0;
	else
		return p->mypoly[i];
}

int polyDegree (struct poly *p) {

	int i = 0;
	
	/*Checks for the non-zero coefficient with the largst degree*/
	for (i = p->length - 1; i >= 0; i--)
	
		if (p->mypoly[i])
			return i;
	return 0;
}

void polyPrint (struct poly *p) {

	int i, k;
	int next_nonzero;
	int is_nonzero = 0;
	
	for (i = p->length-1; i >= 0; i--) {

		if (p->mypoly[i] != 0) {
			is_nonzero = 1;  //checks if entire polynomial exists
			next_nonzero = -1;  
			// Find next non-zero coefficient 
			for (k = i-1; k >= 0; k--) {
				if (p->mypoly[k] != 0){
					next_nonzero = k;
					break;
				}
			}

			// Show the coefficient if it's not +/-1 or it's a degree 0 coefficient
			if (i == 0 || fabs(p->mypoly[i]) != 1) {
				printf("%g", fabs(p->mypoly[i]));
			}
			// Show x if degree is at least 1
			if (i > 0) {
				printf("x");
				if (i > 1) {
					printf("^%d", i);
				}
			}
			if (next_nonzero != -1) {
				if (p->mypoly[next_nonzero] > 0) {
					printf(" + ");
				} else if (p->mypoly[next_nonzero] < 0) {
					printf(" - ");
				}
			}
		}
	}

	if (!is_nonzero)
		printf("0");
	printf("\n");
}

struct poly *polyCopy (struct poly *p) {

	int i = 0;

	struct poly *r = (struct poly *) safeMalloc(sizeof(*p));
	r->mypoly = (double *) safeMalloc(sizeof(double)*p->size);
	r->length = p->length;
	r->size = p->size;

	for (i = 0; i < r->length; i++)
		r->mypoly[i] = p->mypoly[i];

	return r;
}
	
struct poly *polyAdd(struct poly *p0, struct poly *p1)
{
	int i = 0;
	struct poly * pmin;
	struct poly * pmax;
	struct poly * r;

	if (p0 == (struct poly *)0 || p1 == (struct poly *)0) {
		return 0;
	}
	
	pmin = (p0->length > p1->length) ? p1 : p0;
	pmax = (p0->length > p1->length) ? p0 : p1;
	
	r = polyCopy(pmax);

	for (i = 0; i < pmin->length; i++)
		r->mypoly[i] += pmin->mypoly[i];


	return r;
}

struct poly *polyMultiply (struct poly *p0, struct poly *p1) {

	int i, k;
	struct poly *r; 
	int largest_degree; 

	if (p0 == (struct poly *)0 || p1 == (struct poly *)0)
		return 0;

	r = polyCreate();
	largest_degree = polyDegree(p0) + polyDegree(p1);

	polySetCoefficient(r, largest_degree, 0);

	for (i = 0; i < p0->length; i++){
		if (p0->mypoly[i] == 0)
			continue;
		for (k = 0; k < p1->length; k++){
			r->mypoly[i+k] += p0->mypoly[i]*p1->mypoly[k];
		}
	}

	return r;
}

struct poly *polyPrime (struct poly *p) {

	int i;
	struct poly *r;

	if (p == (struct poly *)0)
		return 0;

	r = polyCreate();

	for (i = 1; i < p->length; i ++)
		polySetCoefficient(r, i-1, p->mypoly[i]*i);
	
	return r;
}

double polyEval (struct poly *p, double x){

	int i;
	double y;

	if (p == (struct poly *)0)
		return 0;

	y = p->mypoly[p->length-1];

	for (i = p->length - 2; i>= 0; --i)
		y = y*x + p->mypoly[i];

	return y;

}

