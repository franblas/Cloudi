package utils;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

/**
 * 
 * @author Paco
 *
 */
public class BashUtils {

	/**
	* See output command in sudo mode
	* @param command
	* @param sudopwd
	* @return
	*/
	public String outputCommand(String command, String sudopwd){
		String s = null;
		String t = "";
		String[] com = {"/bin/sh","-c","echo '"+sudopwd+"' | sudo -S "+command};
		try {
			Process proc = Runtime.getRuntime().exec(com);
			BufferedReader stdInput = new BufferedReader(new InputStreamReader(proc.getInputStream()));
			//read output from the command
			while ((s=stdInput.readLine()) != null){
				t = t+s+"\n";
			}
		}
		catch (IOException e) {
			e.printStackTrace();
		}
		return t; //return output of the command
	}
	
	/**
	 * See only one line of output command in sudo mode 
	 * @param command
	 * @param sudopwd
	 * @return
	 */
	public String outputCommand2(String command, String sudopwd){
		String s = null;
		String[] com = {"/bin/bash","-c","echo '"+sudopwd+"' | sudo -S "+command};
		try {
			//definition process et sortie
			Process proc = Runtime.getRuntime().exec(com);
			BufferedReader stdInput = new BufferedReader(new InputStreamReader(proc.getInputStream()));
			//read output from the command
			s=stdInput.readLine();
		}
		catch (IOException e) {
			e.printStackTrace();
		}
		return s; //return output of the command
	}

}//end of class
