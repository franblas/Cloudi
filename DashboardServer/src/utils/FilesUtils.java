package utils;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

/**
 * 
 * @author Paco
 *
 */
public class FilesUtils {

	/**
	* Write in a file
	* @param filename
	* @param message
	*/
	public void writeFile(String filename, String message){
		BufferedWriter writer;
		try{
			writer = new BufferedWriter(new FileWriter(""+filename));
			writer.write(""+message);
			writer.close();
		}
		catch(IOException e){
			e.printStackTrace();
		}
	}

}//end of class
