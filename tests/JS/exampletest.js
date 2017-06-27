/**
 * Created by sanjibdevnath on 27/6/17.
 */

var expect  = require("chai").expect;

describe("Test", function () {
   it("should Do a simple test", function () {
       expect(4+8).equal(12);
   });

    it("should Do another simple test", function () {
        expect(4+8+1).equal(13);
    });
});